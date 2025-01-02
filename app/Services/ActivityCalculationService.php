<?php
namespace App\Services;

use App\Models\Package;
use App\Models\Plane;
use App\Models\PlaneUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ActivityCalculationService
{
    public function validateInputs(array $inputs): bool
    {
        if (empty($inputs['event']) || empty($inputs['plane_id']) || empty($inputs['user_id'])) {
            return false;
        }
        $planeRequireEventTimes = $this->requiresEventTimes($inputs['plane_id']);
        $planeRequireCounters = $this->requiresCounters($inputs['plane_id']);
        Log::channel('pricing')->info('Plane calculation method:', ['eventTimes' => $planeRequireEventTimes, 'counters' => $planeRequireCounters]);

        if (
            $this->requiresEventTimes($inputs['plane_id']) &&
            (empty($inputs['event_start']) || empty($inputs['event_stop']))
        ) {
            return false;
        }

        if (
            $this->requiresCounters($inputs['plane_id']) &&
            (empty($inputs['counter_start']) || empty($inputs['counter_stop']))
        ) {
            return false;
        }

        return true;
    }


    public function calculate(array $inputs): array
    {
        Log::channel('pricing')->info('Calculating:', $inputs);
        $plane = Plane::find($inputs['plane_id']);
        if (!$plane) {
            return $this->defaultResponse();
        }

        $minutes = $this->calculateMinutes($inputs, $plane);

        $amountData = $this->calculatePricing($inputs, $minutes, $plane);

        return array_merge($amountData, ['minutes' => $minutes]);
    }

    protected function calculateMinutes(array $inputs, Plane $plane): int
    {
        if ($this->requiresEventTimes($plane->id)) {
            return max(0, Carbon::parse($inputs['event_start'])->diffInMinutes(Carbon::parse($inputs['event_stop'])));
        }

        if ($this->requiresCounters($plane->id)) {

            if ($plane->counter_type === '100') {
                return (int)round(max(0, ($inputs['counter_stop'] - $inputs['counter_start']) * 60));
            } elseif ($plane->counter_type === '060') {
                return (int)round(max(0, ($inputs['counter_stop'] - $inputs['counter_start']) * 60));
            }

        }

        return 0;
    }

    protected function calculatePricing(array $inputs, int $minutes, Plane $plane): array
    {
        // Default prices from Plane model
        $basePrice = $plane->default_price_per_minute ?? 0;
        $instructorPrice = $plane->instructor_price_per_minute ?? 0;
        $pricingLogic = 'Aircraft defaults';

        Log::channel('pricing')->info('Default prices loaded from aircraft', [
            'pricing_logic' => $pricingLogic,
            'base_price_per_minute' => $basePrice,
            'instructor_price_per_minute' => $instructorPrice,
        ]);

        // Check for individual pricing in PlaneUser model
        if (!empty($inputs['user_id'])) {
            $planeUser = PlaneUser::where('plane_id', $inputs['plane_id'])
                ->where('user_id', $inputs['user_id'])
                ->first();

            if ($planeUser) {
                $basePrice = $planeUser->getBasePricePerMinute(); // Individual base price
                $instructorPrice = !empty($inputs['instructor_id'])
                    ? $planeUser->getInstructorPricePerMinute()
                    : $instructorPrice;
                $pricingLogic = 'User based individual';

                Log::channel('pricing')->info('Individual pricing found and applied', [
                    'pricing_logic' => $pricingLogic,
                    'user_id' => $inputs['user_id'],
                    'base_price_per_minute' => $basePrice,
                    'instructor_price_per_minute' => $instructorPrice,
                ]);
            }
        }

        // Calculate the total amount
        // Modified logic
        $calculatedAmount = ($inputs['counter_stop'] - $inputs['counter_start']) * 100 * $basePrice;
//        $calculatedAmount = round($basePrice * $minutes, 2);

        // Add instructor price only if an instructor is selected
        if (!empty($inputs['instructor_id'])) {
            $calculatedAmount += ($inputs['counter_stop'] - $inputs['counter_start']) * 100 * $instructorPrice;
//            $calculatedAmount += round($instructorPrice * $minutes, 2);
        }

        Log::channel('pricing')->info('Amount calculated before package pricing', [
            'calculated_amount' => $calculatedAmount,
        ]);

        // Apply package pricing
        return $this->applyPackagePricing($inputs, $calculatedAmount, $minutes, $pricingLogic);
    }

    public function applyPackagePricing(array $inputs, float $calculatedAmount, int $minutes, string $pricingLogic): array
    {
        $userId = $inputs['user_id'];
        $planeId = $inputs['plane_id'];
        $instructorId = $inputs['instructor_id'] ?? null;

        $activePackage = Package::where('user_id', $userId)
            ->where(function ($query) use ($planeId) {
                $query->whereNull('plane_id') // Valid for all Planes
                ->orWhere('plane_id', $planeId); // Check individual plane
            })
            ->when($instructorId !== null, function ($query) {
                $query->where('instructor_included', true);
            })
            ->whereDate('valid_from', '<=', Carbon::parse($inputs['event']))
            ->whereDate('valid_until', '>=', Carbon::parse($inputs['event']))
            ->first();

        if ($activePackage) {
            $remainingMinutes = $activePackage->getRawOriginal('remaining_minutes');
            $initialMinutes = $activePackage->getRawOriginal('initial_minutes');

            $packageMinutePrice = $initialMinutes > 0
                ? $activePackage->price / $initialMinutes
                : 0;

            $usedMinutes = min($remainingMinutes, $minutes);
            // ToDo: align logic
//            $packageAmount = round($usedMinutes * $packageMinutePrice, 2);
            $packageAmount = ($inputs['counter_stop'] - $inputs['counter_start']) * 100 * $packageMinutePrice;
            $newRemainingMinutes = $remainingMinutes - $usedMinutes;

            $extraMinutes = $minutes - $usedMinutes;
            $extraAmount = round(($calculatedAmount / $minutes) * $extraMinutes, 2);
            $pricingLogic = 'Packaged';

            return [
                'pricing_logic' => $pricingLogic,
                'amount' => $packageAmount + $extraAmount,
                'package_used' => true,
                'used_minutes' => $usedMinutes,
                'remaining_minutes' => $newRemainingMinutes,
                'package_id' => $activePackage->id,
                'package_name' => $activePackage->name,
                'package_price' => $activePackage->price,
            ];
        }

        return [
            'amount' => $calculatedAmount,
            'pricing_logic' => $pricingLogic,
            'package_used' => false,
        ];
    }

    protected function requiresEventTimes(int $planeId): bool
    {
        return $this->getPlaneCounterType($planeId) === '000';
    }

    protected function requiresCounters(int $planeId): bool
    {
        return $this->getPlaneCounterType($planeId) !== '000';
    }

    protected function getPlaneCounterType(int $planeId): ?string
    {
        $plane = Plane::find($planeId);
        return $plane?->counter_type;
    }


    protected function defaultResponse(): array
    {
        return [
            'amount' => 0,
            'minutes' => 0,
        ];
    }
}

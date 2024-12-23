<?php

namespace App\Services;

use App\Models\Package;
use Carbon\Carbon;
use App\Models\Plane;
use App\Models\PlaneUser;
use Illuminate\Support\Facades\Log;

class ActivityCalculationService
{
    public function calculateMinutes(array $inputs): int
    {
        $plane = Plane::find($inputs['plane_id']);
        if (!$plane) {
            Log::channel('pricing')->warning('Plane not found for minute calculation', ['inputs' => $inputs]);
            return 0;
        }

        $minutes = 0;

        if ($plane->counter_type === '000' && !empty($inputs['event_start']) && !empty($inputs['event_stop'])) {
            // Calculate minutes based on event times
            $minutes = Carbon::parse($inputs['event_start'])->diffInMinutes(Carbon::parse($inputs['event_stop']));
        } elseif (in_array($plane->counter_type, ['100', '060']) && isset($inputs['counter_start'], $inputs['counter_stop'])) {
            // Calculate minutes based on counters
            $counterStart = $inputs['counter_start'];
            $counterStop = $inputs['counter_stop'];

            if ($plane->counter_type === '100') {
                $minutes = round(($counterStop - $counterStart) * 100 / 5 * 3, 2); // Industrial minutes
            } elseif ($plane->counter_type === '060') {
                $minutes = round(($counterStop - $counterStart) * 60, 2); // Hours and minutes
            }
        }

        return max(0, $minutes); // Ensure no negative values
    }

    public function calculatePricing(array $inputs, int $minutes): array
    {
        $plane = Plane::find($inputs['plane_id']);
        if (!$plane) {
            Log::channel('pricing')->warning('Plane not found for pricing calculation', ['inputs' => $inputs]);
            return $this->defaultPricingResponse();
        }

        // Default prices from Plane model
        $basePrice = $plane->default_price_per_minute ?? 0;
        $instructorPrice = $plane->instructor_price_per_minute ?? 0;

        Log::channel('pricing')->info('Default prices loaded from aircraft', [
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

                Log::channel('pricing')->info('Individual pricing found and applied', [
                    'user_id' => $inputs['user_id'],
                    'base_price_per_minute' => $basePrice,
                    'instructor_price_per_minute' => $instructorPrice,
                ]);
            }
        }

        // Calculate the total amount
        $calculatedAmount = round($basePrice * $minutes, 2);

        // Add instructor price only if an instructor is selected
        if (!empty($inputs['instructor_id'])) {
            $calculatedAmount += round($instructorPrice * $minutes, 2);
        }

        Log::channel('pricing')->info('Amount calculated before package pricing', [
            'calculated_amount' => $calculatedAmount,
            'total_minutes' => $minutes,
        ]);

        // Apply package pricing
        $finalAmountData = $this->applyPackagePricing($inputs, $calculatedAmount, $minutes);

        return $finalAmountData + [
                'base_price_per_minute' => $basePrice,
                'instructor_price_per_minute' => $instructorPrice,
            ];
    }

    protected function defaultPricingResponse(): array
    {
        return [
            'base_price_per_minute' => 0,
            'instructor_price_per_minute' => 0,
            'amount' => 0,
            'package_id' => null,
            'package_price' => null,
            'remaining_minutes' => 0,
        ];
    }

    public function applyPackagePricing(array $inputs, float $calculatedAmount, int $minutes): array
    {
        $userId = $inputs['user_id'];
        $planeId = $inputs['plane_id'];
        $instructorIncluded = !empty($inputs['instructor_id']); // Prüfen, ob ein Instructor ausgewählt wurde

        // Find an active package
        $activePackage = Package::where('user_id', $userId)
            ->where(function ($query) use ($planeId) {
                $query->whereNull('plane_id') // General Package
                ->orWhere('plane_id', $planeId); // Package Plane specific
            })
            ->where(function ($query) use ($instructorIncluded) {
                $query->where('instructor_included', $instructorIncluded); // Package where Instructor included
            })
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->first();

        if ($activePackage) {
            $remainingMinutes = $activePackage->getRawOriginal('remaining_minutes');
            $initialMinutes = $activePackage->getRawOriginal('initial_minutes');

            $packageMinutePrice = $initialMinutes > 0
                ? $activePackage->price / $initialMinutes
                : 0;

            $usedMinutes = min($remainingMinutes, $minutes);
            $packageAmount = round($usedMinutes * $packageMinutePrice, 2);

            $newRemainingMinutes = $remainingMinutes - $usedMinutes;

            $extraMinutes = $minutes - $usedMinutes;
            $extraAmount = round(($calculatedAmount / $minutes) * $extraMinutes, 2);

            return [
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
            'package_used' => false,
            'used_minutes' => 0,
            'remaining_minutes' => 0,
            'package_id' => null,
            'package_name' => null,
            'package_price' => null,
        ];
    }


}

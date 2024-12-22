<?php

namespace App\Services;

use App\Models\Package;
use Carbon\Carbon;
use App\Models\Plane;
use App\Models\PlaneUser;
use Illuminate\Support\Facades\Log;

class ActivityCalculationService
{
    public function calculateMinutes(array $inputs): array
    {
        $plane = Plane::find($inputs['plane_id']);
        $minutes = 0;
        $warmupMinutes = 0;

        if (!$plane) {
            return [
                'minutes' => $minutes,
                'warmup_minutes' => $warmupMinutes,
            ];
        }

        if ($plane->counter_type === '000' && !empty($inputs['event_start']) && !empty($inputs['event_stop'])) {
            $minutes = Carbon::parse($inputs['event_start'])->diffInMinutes(Carbon::parse($inputs['event_stop']));
        } elseif (in_array($plane->counter_type, ['100', '060'])) {
            $counterStart = $inputs['counter_start'];
            $counterStop = $inputs['counter_stop'];
            $warmupCounter = $inputs['warmup_start'];

            if ($plane->counter_type === '100') {
                if ($warmupCounter) {
                    $warmupMinutes = round(($counterStart - $warmupCounter) * 100 / 5 * 3, 2);
                }
                $minutes = round(($counterStop - $counterStart) * 100 / 5 * 3, 2);
            } elseif ($plane->counter_type === '060') {
                if ($warmupCounter) {
                    $warmupMinutes = round(($counterStart - $warmupCounter) * 60, 2);
                }
                $minutes = round(($counterStop - $counterStart) * 60, 2);
            }
        }

        return [
            'minutes' => $minutes,
            'warmup_minutes' => $warmupMinutes,
        ];
    }

    /**
     * Calculate the amount for an activity, considering packages, individual prices, and defaults.
     *
     * @param array $inputs Input data including user, plane, and instructor.
     * @param int $minutes Total activity minutes.
     * @param int $warmupMinutes Additional warmup minutes (if applicable).
     * @return array Calculated amount, individual prices, and package details.
     */
    public function calculateAmount(array $inputs, int $minutes, int $warmupMinutes): array
    {
        $plane = Plane::find($inputs['plane_id']);
        if (!$plane) {
            Log::channel('pricing')->warning('Plane not found for pricing calculation', ['inputs' => $inputs]);

            return [
                'base_price_per_minute' => 0,
                'instructor_price_per_minute' => 0,
                'amount' => 0,
                'package_id' => null,
                'package_price' => null,
                'remaining_minutes' => 0,
            ];
        }

        $totalMinutes = $plane->warmup_type == 0 ? $minutes : $minutes + $warmupMinutes;

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
                if (!empty($inputs['instructor_id'])) {
                    $instructorPrice = $planeUser->getInstructorPricePerMinute(); // Individual instructor price
                }

                Log::channel('pricing')->info('Individual pricing found and applied', [
                    'user_id' => $inputs['user_id'],
                    'base_price_per_minute' => $basePrice,
                    'instructor_price_per_minute' => $instructorPrice,
                ]);
            } else {
                Log::channel('pricing')->info('No individual pricing found for user', [
                    'user_id' => $inputs['user_id'],
                ]);
            }
        }

        // Calculate the total amount
        $calculatedAmount = round($basePrice * $totalMinutes, 2);

        // Add instructor price only if an instructor is selected
        if (!empty($inputs['instructor_id'])) {
            $calculatedAmount += round($instructorPrice * $totalMinutes, 2);
        }

        Log::channel('pricing')->info('Amount calculated before package pricing', [
            'calculated_amount' => $calculatedAmount,
            'total_minutes' => $totalMinutes,
        ]);

        // Apply package pricing
        $finalAmountData = $this->applyPackagePricing($inputs, $calculatedAmount, $totalMinutes);

        Log::channel('pricing')->info('Final amount after package pricing', [
            'final_amount' => $finalAmountData['amount'],
            'package_used' => $finalAmountData['package_used'],
            'package_id' => $finalAmountData['package_id'],
            'package_price' => $finalAmountData['package_price'],
        ]);

        return $finalAmountData + [
                'base_price_per_minute' => $basePrice,
                'instructor_price_per_minute' => $instructorPrice,
            ];
    }

    public function applyPackagePricing(array $inputs, float $calculatedAmount, int $minutes): array
    {
        $userId = $inputs['user_id'];
        $planeId = $inputs['plane_id'];
        $instructorId = $inputs['instructor_id'];

        // Find an active package
        $activePackage = Package::where('user_id', $userId)
            ->where(function ($query) use ($planeId) {
                $query->whereNull('plane_id') // General package
                ->orWhere('plane_id', $planeId); // Specific to a plane
            })
            ->where(function ($query) use ($instructorId) {
                $query->whereNull('instructor_id') // General package
                ->orWhere('instructor_id', $instructorId); // Specific to an instructor
            })
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->first();

        if ($activePackage) {
            // Directly access raw database values without Accessors
            $remainingMinutes = $activePackage->getRawOriginal('remaining_minutes');
            $initialMinutes = $activePackage->getRawOriginal('initial_minutes');

            // Prevent division by zero
            $packageMinutePrice = $initialMinutes > 0
                ? $activePackage->price / $initialMinutes
                : 0;

            // Calculate used minutes and package amount
            $usedMinutes = min($remainingMinutes, $minutes);
            $packageAmount = round($usedMinutes * $packageMinutePrice, 2);

            // Calculate remaining minutes
            $newRemainingMinutes = $remainingMinutes - $usedMinutes;

            // Log applied package details
            Log::channel('pricing')->info('Package applied', [
                'package_id' => $activePackage->id,
                'name' => $activePackage->name,
                'used_minutes' => $usedMinutes,
                'remaining_minutes' => $newRemainingMinutes,
                'package_amount' => $packageAmount,
            ]);

            // If there are extra minutes beyond the package, calculate their cost
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

        // Log no package applied
        Log::channel('pricing')->info('No package applied', [
            'calculated_amount' => $calculatedAmount,
            'user_id' => $userId,
            'plane_id' => $planeId,
        ]);

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

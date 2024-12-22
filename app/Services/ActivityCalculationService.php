<?php

namespace App\Services;

use App\Models\Package;
use Carbon\Carbon;
use App\Models\Plane;
use App\Models\PlaneUser;

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
            // Return default values if the plane is not found
            return [
                'base_price_per_minute' => 0,
                'instructor_price_per_minute' => 0,
                'amount' => 0,
            ];
        }

        // Default prices from the plane
        $basePrice = $plane->default_price_per_minute;
        $instructorPrice = $plane->instructor_price_per_minute;

        // Check for individual pricing for the user and plane
        if ($inputs['user_id']) {
            $planeUser = PlaneUser::where('plane_id', $inputs['plane_id'])
                ->where('user_id', $inputs['user_id'])
                ->first();

            $basePrice = $planeUser?->getBasePricePerMinute() ?? $basePrice;
            if ($inputs['instructor_id']) {
                $instructorPrice = $planeUser?->getInstructorPricePerMinute() ?? $instructorPrice;
            }
        }

        // Calculate total minutes, considering warmup
        $totalMinutes = $plane->warmup_type == 0 ? $minutes : $minutes + $warmupMinutes;

        // Calculate the amount without package discounts
        $calculatedAmount = round(($basePrice + $instructorPrice) * $totalMinutes, 2);

        // Apply package pricing if applicable
        return $this->applyPackagePricing($inputs, $calculatedAmount, $totalMinutes);
    }

    public function applyPackagePricing(array $inputs, float $calculatedAmount, int $minutes): array
    {
        $userId = $inputs['user_id'];
        $planeId = $inputs['plane_id'];
        $instructorId = $inputs['instructor_id'];

        // Find an active package for the user that matches the conditions
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

        // If an active package is found, apply its pricing logic
        if ($activePackage) {
            switch ($activePackage->type) {
                case 'hourly':
                    $remainingMinutes = ($activePackage->hours * 60) - $minutes;

                    // Use package pricing if minutes are within the package limit
                    if ($remainingMinutes >= 0) {
                        return [
                            'amount' => min($calculatedAmount, $activePackage->price),
                            'package_used' => true,
                            'remaining_minutes' => $remainingMinutes,
                        ];
                    }
                    break;

                case 'fixed':
                    // Apply fixed price regardless of minutes
                    return [
                        'amount' => $activePackage->price,
                        'package_used' => true,
                        'remaining_minutes' => 0,
                    ];
            }
        }

        // No active package or package minutes exceeded
        return [
            'amount' => $calculatedAmount,
            'package_used' => false,
            'remaining_minutes' => 0,
        ];
    }


}

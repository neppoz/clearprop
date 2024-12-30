<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Plane;
use App\Models\User;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationValidator
{
    /**
     * Validates if the user has a valid Medical.
     *
     * @param User $user
     * @return bool
     */
    public static function validateMedical(User $user): bool
    {
        $settings = app(GeneralSettings::class);

        // Check if medical validation is enabled
        if ($settings->check_medical) {

            // If no medical_due date is set or the date is in the past, validation fails
            if (empty($user->medical_due) || Carbon::parse($user->medical_due)->isPast()) {
                Log::info("{$user->name} has invalid medical. Date is: {$user->medical_due}");
                return false;
            }
        }

        return true;
    }

    /**
     * Validates if the user's balance meets the minimum requirements.
     *
     * @param User $user
     * @return bool
     */
    public static function validateBalance(User $user): bool
    {
        $settings = app(GeneralSettings::class);

        // Check if balance validation is enabled
        if ($settings->check_balance) {

            $userBalance = (new StatisticsService())->validateBalanceCalculation($user);

            // Check if balance validation is e below the allowed limit
            if ($userBalance < $settings->check_balance_limit_amount) {
                Log::info("User {$user->id} exceeded balance limit. Balance: {$userBalance}, Limit: {$settings->check_balance_limit_amount}");
                return false;
            }
        }

        return true;
    }

    /**
     * Validates if the user's airworthiness is still valid based on their recent activities.
     *
     * @param $reservationStartDate
     * @param Plane $plane
     * @param User $user
     * @return bool
     */
    public static function validateAirworthiness($reservationStartDate, Plane $plane, User $user): bool
    {
        $settings = app(GeneralSettings::class);

        if ($settings->check_activities) {

            $activityLimitDays = $settings->check_activities_limit_days ?? 0;


            // Get the user's last activity for the selected plane
            $lastActivity = Activity::where('plane_id', $plane->id)
                ->where('user_id', $user->id)->orderByDesc('event')->first();

            // If no previous activity is found, return false
            if (!$lastActivity) {
                Log::info("No previous activity for {$user->name} with {$plane->callsign} found");
                return false;
            } else {
                $lastActivityDate = Carbon::parse($lastActivity->event);

                // If last activity is before the reservation start date, check the days difference
                if ($lastActivityDate->lessThan($reservationStartDate)) {
                    $daysSinceLastActivity = $lastActivityDate->diffInDays($reservationStartDate);

                    if ($daysSinceLastActivity >= $activityLimitDays) {
                        Log::info("User {$user->name} exceeded airworthiness limit. Days since last activity: {$daysSinceLastActivity}, Limit: {$settings->check_activities_limit_days}");
                        return false;
                    }
                }

            }
        }

        return true;
    }

    /**
     * Validates if a reservation overlaps with existing reservations.
     *
     * @param Plane $plane
     * @param $startTime
     * @param $endTime
     * @param int|null $bookingId
     * @return bool
     */
    public static function validateOverlappingReservation(Plane $plane, $startTime, $endTime, ?int $bookingId = null): bool
    {
        // Check for overlapping reservations
        return Plane::where('id', $plane->id)
            ->whereHas('planeBookings', function ($query) use ($startTime, $endTime, $bookingId) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('reservation_start', '<', $endTime)
                        ->where('reservation_stop', '>', $startTime);
                });

                // Exclude the current booking if editing
                if ($bookingId !== null) {
                    $query->where('id', '!=', $bookingId);
                }
            })
            ->exists();
    }
}

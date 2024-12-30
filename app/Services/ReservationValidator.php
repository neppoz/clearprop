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
     * @param array $data
     * @param int|null $bookingId
     * @return bool
     */
    // ToDo: Refactor a little bit..
    public static function validateOverlappingReservation(array $data, ?int $bookingId = null): bool
    {
        // Ensure that only the date part of reservation_start_date is used
        $startDate = Carbon::parse($data['reservation_start_date'])->toDateString();
        $startTime = Carbon::parse($startDate . ' ' . $data['reservation_start_time']);

        // Ensure that only the date part of reservation_stop_date is used
        $endDate = Carbon::parse($data['reservation_stop_date'])->toDateString();
        $endTime = Carbon::parse($endDate . ' ' . $data['reservation_stop_time']);

        $planeId = $data['plane_id'];

        // Check for overlapping reservations
        $overlapExists = Plane::where('id', $planeId)
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

        return !$overlapExists; // Return `true` only if no overlap exists
    }


    /**
     * Validates all conditions for creating or editing a reservation.
     *
     * @param array $data
     * @param User $selectedUser
     * @return bool
     */
    public static function validateAll(array $data, User $selectedUser): bool
    {
        $validators = [
            'Medical invalid' => self::validateMedical($selectedUser),
            'Insufficient balance' => self::validateBalance($selectedUser),
            'Overlapping reservation' => self::validateOverlappingReservation($data, $data['id'] ?? null),
            'Airworthiness expired' => self::isAirworthinessExpired($data, $selectedUser),
        ];

        $validationPassed = true;
        $currentUser = Auth::user(); // User who is filling out the form

        foreach ($validators as $message => $result) {
            if (!$result) {
                if ($currentUser->is_admin || $currentUser->is_manager) {
                    // Show warning for Admins and Managers, but do not block the process
                    Notification::make()
                        ->title($message)
                        ->body('Validation issue detected.')
                        ->warning()
                        ->send();
                } else {
                    // For other users, show an error and block the process
                    Notification::make()
                        ->title($message)
                        ->body('Validation issue detected!')
                        ->danger()
                        ->send();

                    $validationPassed = false; // Mark as failed for non-admins/managers
                }
            }
        }

        return $validationPassed; // True if admin/manager or all validations passed
    }

    /**
     * Validates if the user's airworthiness is still valid based on their recent activities.
     *
     * @param array $data
     * @param User $user
     * @return bool
     */
    public static function isAirworthinessExpired(array $data, User $user): bool
    {
        $settings = app(GeneralSettings::class);

        if (!($settings->check_activities ?? false)) {
            return true;
        }

        $activityLimitDays = $settings->check_activities_limit_days ?? 0;

        $planeId = $data['plane_id'];
        $reservationStartDate = Carbon::parse($data['reservation_start_date']);

        // Get the user's last activity for the selected plane
        $lastActivity = Activity::where('plane_id', $planeId)
            ->where('user_id', $user->id)
            ->orderByDesc('event')
            ->first();

        // If no activity is found, return false (validation fails)
        if (!$lastActivity) {
            return false; // No valid activity -> fails validation
        }

        $lastActivityDate = Carbon::parse($lastActivity->event);

        // If last activity is before the reservation start date, check the days difference
        if ($lastActivityDate->lessThan($reservationStartDate)) {
            $daysSinceLastActivity = $lastActivityDate->diffInDays($reservationStartDate);

            return $daysSinceLastActivity <= $activityLimitDays; // true = valid, false = fails validation
        }

        // If the last activity is after or equal to the reservation start date, airworthiness is valid
        return true;
    }
}

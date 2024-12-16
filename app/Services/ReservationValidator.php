<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Plane;
use App\Models\User;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ReservationValidator
{
    /**
     * Checks if the user can access the Create Page.
     *
     * @param User $user
     * @return bool
     */
    public static function canAccessCreatePage(User $user): bool
    {
        // Admins and Managers are always allowed
        if ($user->is_admin || $user->is_manager) {
            return true;
        }

        // Members need to pass both Medical and Balance validations
        return self::validateMedical($user) && self::validateBalance($user);
    }

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
        $userBalance = (new StatisticsService())->calculateUserBalance($user);

        // Check if balance validation is enabled and balance is below the allowed limit
        if ($settings->check_balance && $userBalance < $settings->check_balance_limit_amount) {
            return false;
        }

        return true;
    }

    /**
     * Validates all conditions for creating or editing a reservation.
     *
     * @param array $data
     * @param User $user
     * @param bool $isEdit
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
                        ->body('Validation issue detected for the selected user. You can proceed as an Admin or Manager.')
                        ->warning()
                        ->send();
                } else {
                    // For other users, show an error and block the process
                    Notification::make()
                        ->title($message)
                        ->body('Validation issue detected for the selected user. You cannot proceed.')
                        ->danger()
                        ->send();

                    $validationPassed = false; // Mark as failed for non-admins/managers
                }
            }
        }

        return $validationPassed; // True if admin/manager or all validations passed
    }

    /**
     * Validates if a reservation overlaps with existing reservations.
     *
     * @param array $data
     * @param int|null $bookingId
     * @return bool
     */
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
     * Validates if the user's airworthiness is still valid based on their recent activities.
     *
     * @param array $data
     * @param User $user
     * @return bool
     */
    public static function isAirworthinessExpired(array $data, User $user): bool
    {
        $settings = app(GeneralSettings::class);
        $activityLimitDays = $settings->check_activities_limit_days ?? 90;
        $planeId = $data['plane_id'];
        $reservationStartDate = Carbon::parse($data['reservation_start_date']);

        // Get the user's last activity for the selected plane
        $lastActivity = Activity::where('plane_id', $planeId)
            ->where('user_id', $user->id)
            ->orderByDesc('event')
            ->first();

        // If no activity is found, the airworthiness is considered invalid
        if (!$lastActivity) {
            return true;
        }

        // Calculate the difference in days between the last activity and the reservation start date
        $daysSinceLastActivity = $reservationStartDate->diffInDays(Carbon::parse($lastActivity->event));

        // Return true if no activity found or the difference exceeds the allowed limit
        return $daysSinceLastActivity > $activityLimitDays;
    }


}

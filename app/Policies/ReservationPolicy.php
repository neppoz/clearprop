<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use App\Services\ReservationValidator;
use App\Settings\GeneralSettings;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ReservationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user): bool
    {
        // Admins and Managers are always allowed
        if ($user->is_admin || $user->is_manager) {
            return true;
        }

        if ($user->is_member) {
            $settings = app(GeneralSettings::class);

            // Medical Check
            if ($settings->check_medical) {
                if (!ReservationValidator::validateMedical($user)) {
                    return false; // Validation failed
                }
            } else {
                Log::info("Medical validation is disabled. Skipping check for {$user->name}.");
            }

            // Balance-Check
            if ($settings->check_balance) {
                if (!ReservationValidator::validateBalance($user)) {
                    return false; // Validation failed
                }
            } else {
                Log::info("Balance validation is disabled. Skipping check for {$user->name}.");
            }

            // Note that airworthiness can not be checked on create.
            // It is based on selected aircraft...

            Log::info("All validations passed for {$user->name}.");
            return true;
        }

        // Fallback: Create not allowed
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        // Same logic as for "update"
        return $this->update($user, $reservation);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        if ($user->is_admin) {
            return true;
        }

        // Check if the user is associated with the reservation
        if ($user->is_member) {
            return $this->isUserAssociatedWithReservation($user, $reservation, 'bookingUsers');
        }

        if ($user->is_instructor) {
            return $this->isUserAssociatedWithReservation($user, $reservation, 'bookingInstructors');
        }

        return false;
    }

    protected function isUserAssociatedWithReservation(User $user, Reservation $reservation, string $relation): bool
    {
        if (!method_exists($reservation, $relation)) {
            return false; // Avoid errors if the relation doesn't exist
        }

        return $reservation->{$relation}()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return false;
    }
}

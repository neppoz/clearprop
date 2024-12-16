<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    use HandlesAuthorization;

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

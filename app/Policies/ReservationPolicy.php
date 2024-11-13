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
        // Dieselbe Logik wie bei "update" anwenden
        return $this->update($user, $reservation);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        // Admin-Benutzer können alle Reservierungen bearbeiten
        if ($user->roles->contains(User::IS_ADMIN)) {
            return true;
        }

        // Member können nur ihre eigenen Reservierungen bearbeiten
        if ($user->roles->contains(User::IS_MEMBER)) {
            return $reservation->bookingUsers()->where('user_id', $user->id)->exists();
        }

        // Instructors können nur jene Reservierungen bearbeiten, denen sie als Instructor zugeordnet sind
        if ($user->roles->contains(User::IS_INSTRUCTOR)) {
            return $reservation->bookingInstructors()->where('user_id', $user->id)->exists();
        }

        return false; // Falls keine der Bedingungen zutrifft, Bearbeitungszugriff verweigern
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        if ($user->roles->contains(User::IS_ADMIN)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        if ($user->roles->contains(User::IS_ADMIN)) {
            return true;
        }
        return false;
    }
}

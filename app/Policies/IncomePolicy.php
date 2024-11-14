<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IncomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Income $income): bool
    {
        // Dieselbe Logik wie bei "update" anwenden
        return $this->update($user, $income);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Income $income): bool
    {
        // Admin-Benutzer können alle Zahlungen bearbeiten
        if ($user->is_admin) {
            return true;
        }

        return false; // Falls keine der Bedingungen zutrifft, Bearbeitungszugriff verweigern
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

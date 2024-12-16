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
     * Determine if the user can view the income record.
     */
    public function view(User $user, Income $income): bool
    {
        // Users can view if they are the owner (user_id matches)
        return $income->user_id === $user->id;
    }

    /**
     * Determine whether the user can create records.
     */
    public function create(User $user): bool
    {
        if ($user->is_admin || $user->is_manager) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Income $income): bool
    {
        // Same logic as for "update"
        return $this->update($user, $income);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return false;
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

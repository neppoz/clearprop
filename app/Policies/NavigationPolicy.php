<?php

namespace App\Policies;

use App\Models\User;

class NavigationPolicy
{
    public function viewReservations(User $user): bool
    {
        return $user->hasRole(User::IS_ADMIN) || $user->hasRole(User::IS_MEMBER);
    }

    public function viewActivities(User $user): bool
    {
        return $user->hasRole(User::IS_ADMIN) || $user->hasRole(User::IS_MEMBER);
    }

    public function viewPayments(User $user): bool
    {
        return $user->hasRole(User::IS_ADMIN) || $user->hasRole(User::IS_MEMBER);
    }

    public function viewUsers(User $user): bool
    {
        return $user->hasRole(User::IS_ADMIN);
    }

    public function viewAircrafts(User $user): bool
    {
        return $user->hasRole(User::IS_ADMIN);
    }

    public function viewSettings(User $user): bool
    {
        return $user->hasRole(User::IS_ADMIN);
    }
}

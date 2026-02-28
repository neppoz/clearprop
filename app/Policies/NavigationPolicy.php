<?php

namespace App\Policies;

use App\Models\User;

class NavigationPolicy
{
    public function viewReservations(User $user): bool
    {
        return $user->is_admin || $user->is_member || $user->is_instructor || $user->is_mechanic;
    }

    public function viewActivities(User $user): bool
    {
        return $user->is_admin || $user->is_member || $user->is_instructor || $user->is_mechanic;
    }

    public function viewPayments(User $user): bool
    {
        return $user->is_admin || $user->is_member || $user->is_instructor || $user->is_mechanic;
    }

    public function viewUsers(User $user): bool
    {
        return $user->is_admin;
    }

    public function viewAircrafts(User $user): bool
    {
        return $user->is_admin;
    }

    public function viewAssets(User $user): bool
    {
        return $user->is_admin;
    }

    public function viewPackages(User $user): bool
    {
        return $user->is_admin;
    }

    public function viewSettings(User $user): bool
    {
        return $user->is_admin;
    }

    public function viewReports(User $user): bool
    {
        return $user->is_admin;
    }
}

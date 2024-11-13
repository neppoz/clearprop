<?php

namespace App\Policies;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activity $activity): bool
    {
        // Dieselbe Logik wie bei "update" anwenden
        return $this->update($user, $activity);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activity $activity): bool
    {
        // Admin-Benutzer können alle Zahlungen bearbeiten
        if ($user->roles->contains(User::IS_ADMIN)) {
            return true;
        }

        // Member können nur ihre eigenen Activities bearbeiten, wenn der Status auf New steht
        if ($user->roles->contains(User::IS_MEMBER)) {
            return Activity::where('id', $activity->id)
                ->where('user_id', auth()->id())
                ->where('status', ActivityStatus::New)
                ->exists();
        }

        return false; // Falls keine der Bedingungen zutrifft, Bearbeitungszugriff verweigern
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Activity $activity): bool
    {
        if ($user->roles->contains(User::IS_MEMBER)) {
            return Activity::where('id', $activity->id)
                ->where('user_id', auth()->id())
                ->where('status', ActivityStatus::New)
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Activity $activity): bool
    {
        if ($user->roles->contains(User::IS_MEMBER)) {
            return Activity::where('id', $activity->id)
                ->where('user_id', auth()->id())
                ->where('status', ActivityStatus::New)
                ->exists();
        }

        return false;
    }
}

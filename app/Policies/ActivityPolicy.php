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
        // Same logic as for "update"
        return $this->update($user, $activity);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activity $activity): bool
    {
        if ($user->is_admin) {
            return true;
        }

        if ($user->is_member) {
            return Activity::where('id', $activity->id)
                ->where('user_id', auth()->id())
                ->where('status', ActivityStatus::New)
                ->exists();
        }

        if ($user->is_instructor) {
            return Activity::where('id', $activity->id)
                ->where('user_id', auth()->id())
                ->orWhere('instructor_id', auth()->id())
                ->where('status', ActivityStatus::New)
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Activity $activity): bool
    {
        if ($user->is_admin) {
            return true;
        }

        if ($user->is_member) {
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
        if ($user->is_admin) {
            return true;
        }

        return false;
    }
}

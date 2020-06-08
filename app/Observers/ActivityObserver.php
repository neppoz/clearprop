<?php

namespace App\Observers;

use App\Activity;
use Illuminate\Support\Facades\DB;

class ActivityObserver
{
    /**
     * Handle the activity "saving" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function saving(Activity $activity)
    {
        /** Find the user (pilot dropdown) and get the factor_id */
        $activity_userid = 'App\User'::findOrFail($activity->user_id);
        $factor_id = $activity_userid->factor_id;
        /** Find the type (type dropdown) and get the type_id */
        $activity_typeid = 'App\Type'::findOrFail($activity->type_id);
        $type_id = $activity_typeid->id;
        $rate_to_apply = DB::table('factor_type')
                        ->select('rate')
                        ->where([
                            ['type_id', '=', $type_id],
                            ['factor_id', '=', $factor_id],
                        ])
                        ->pluck('rate');
        /** Check if there is engine warmup */
        if ($activity->engine_warmup == true) {
            $warmup_to_apply = round(($activity->counter_start-$activity->warmup_start)*100/5*3, 2);
            $activity->warmup_minutes = $warmup_to_apply;
        }
        /** Calculate the offset between counter values */
        $minutes_to_apply = round(($activity->counter_stop-$activity->counter_start)*100/5*3, 2);
        $activity->minutes = $minutes_to_apply;
        $activity->rate = $rate_to_apply[0];
        $amount_to_apply = $minutes_to_apply*$rate_to_apply[0];
        $activity->amount = $amount_to_apply;
    }

    /**
     * Handle the activity "retrieved" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function retrieved(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "updating" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function updating(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "deleted" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function deleted(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "restored" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function restored(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "force deleted" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function forceDeleted(Activity $activity)
    {
        //
    }
}

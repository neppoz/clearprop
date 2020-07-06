<?php

namespace App\Listeners;

use App\Events\ActivityCostCalculation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\UserDataVerificationJob;
use Throwable;

use App\User;
use App\Type;
use App\Plane;

class ActivityCostCalculationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActivityCostCalculation  $event
     * @return void
     */
    public function handle(ActivityCostCalculation $event)
    {
        // Access the activity using $event->activity...

        try {
            $user = User::findOrFail($event->activity->user_id);
            $type = Type::findOrFail($event->activity->type_id);
            $plane = Plane::findOrFail($event->activity->plane_id);
            $rate_query = $type->factors()->findOrFail($user->factor_id, ['type_id'])->pivot->rate;

            /** industrial minutes calculation */
            if ($plane->counter_type === '100') {
                $warmup_value = ($event->activity->counter_start) - ($event->activity->warmup_start);
                $regular_value = ($event->activity->counter_stop) - ($event->activity->counter_start);
                $warmup_minutes = round($warmup_value * 100/15, 2);
                $regular_minutes = round($regular_value * 100/15, 2);
                debug('Warmup minutes: '.$warmup_minutes);
                debug('Regular minutes: '.$regular_minutes);
            }
            /** Rolling hours and minutes with a decimal */
            if ($plane->counter_type === '060') {
                $warmup_minutes = ((intval($event->activity->counter_start)*60) + explode('.', number_format($event->activity->counter_start, 2))[1]) - ((intval($event->activity->warmup_start)*60) + explode('.', number_format($event->activity->warmup_start, 2))[1]);
                $regular_minutes = ((intval($event->activity->counter_stop)*60) + explode('.', number_format($event->activity->counter_stop, 2))[1]) - ((intval($event->activity->counter_start)*60) + explode('.', number_format($event->activity->counter_start, 2))[1]);
                debug('Warmup minutes: '.$warmup_minutes);
                debug('Regular minutes: '.$regular_minutes);
            }

            if ($event->activity->engine_warmup == true) {
                $event->activity->warmup_minutes = $warmup_minutes;
            }
            /** Calculate the offset between counter values */
            $event->activity->minutes = $regular_minutes;
            $event->activity->rate = $rate_query;
            /** TODO: Check flag whenwarmup minutes are to pay */
            $amount_to_apply = $regular_minutes*$rate_query;

            $event->activity->amount = $amount_to_apply;

            $event->activity->save();
            /** Dispatch verification job */
            UserDataVerificationJob::dispatch($user);

            return;
            /** */
        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

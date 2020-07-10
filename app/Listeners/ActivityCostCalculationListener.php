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
            $rate = $type->factors()->findOrFail($user->factor_id, ['type_id'])->pivot->rate;

            if ($event->activity->engine_warmup == false) {
                $this->calculationWithoutWarmup($event, $plane, $rate);
            }

            // if ($event->activity->engine_warmup == true) {
            //     $values = $this->calculationWithWarmup($event, $plane, $rate);
            //     debug($values);

            //     // $event->activity->warmup_minutes = $values['warmup_minutes'];
            //     // $event->activity->minutes = $values['regular_minutes'];
            // }

            $event->activity->save();

            /** Dispatch verification job */
            //UserDataVerificationJob::dispatch($user);

            return;
        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }

    public function calculationWithWarmup($event, $plane)
    {
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

        return [$warmup_minutes, $regular_minutes];
    }


    public function calculationWithoutWarmup($event, $plane, $rate)
    {
        /** industrial minutes calculation */
        if ($plane->counter_type === '100') {
            $regular_value = ($event->activity->counter_stop) - ($event->activity->counter_start);
            $regular_minutes = round($regular_value * 100/15, 2);

            $event->activity->rate = $rate;
            $event->activity->amount = $regular_minutes*$rate;
            $event->activity->minutes = $regular_minutes;

            debug('CalcWithoutWarmup:Industrial -> Regular minutes: '.$regular_minutes.' Rate: '.$rate.' Amount:'.$regular_minutes*$rate);
        }

        /** Rolling hours and minutes with a decimal */
        if ($plane->counter_type === '060') {
            $regular_minutes = ((intval($event->activity->counter_stop)*60) + explode('.', number_format($event->activity->counter_stop, 2))[1]) - ((intval($event->activity->counter_start)*60) + explode('.', number_format($event->activity->counter_start, 2))[1]);
            $event->activity->rate = $rate;
            $event->activity->amount = $regular_minutes*$rate;
            debug('CalcWithoutWarmup:HH,min -> Regular minutes: '.$regular_minutes.' Rate: '.$rate.' Amount:'.$regular_minutes*$rate);
        }

        return;
    }
}

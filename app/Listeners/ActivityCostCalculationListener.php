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

            /** */
            $calculation_formula = $plane->counter_type/5*3;
            /** */
            if ($event->activity->engine_warmup == true) {
                $warmup_to_apply = round(($event->activity->counter_start-$event->activity->warmup_start)*$calculation_formula, 2);
                $event->activity->warmup_minutes = $warmup_to_apply;
            }
            /** Calculate the offset between counter values */
            $minutes_to_apply = round(($event->activity->counter_stop-$event->activity->counter_start)*$calculation_formula, 2);
            $event->activity->minutes = $minutes_to_apply;
            $event->activity->rate = $rate_query;
            $amount_to_apply = $minutes_to_apply*$rate_query;
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

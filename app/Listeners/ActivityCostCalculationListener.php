<?php

namespace App\Listeners;

use App\Events\ActivityCostCalculation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\User;
use App\Type;
use App\Plane;
use Illuminate\Support\Facades\DB;
use Throwable;

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
            $userid = User::findOrFail($event->activity->user_id);
            $typeid = Type::findOrFail($event->activity->type_id);
            $planeid = Plane::findOrFail($event->activity->plane_id);

            $rate_to_apply = DB::table('factor_type')
                ->select('rate')
                ->where([
                    ['type_id', '=', $typeid->id],
                    ['factor_id', '=', $userid->factor_id],
                ])
                ->pluck('rate');
            /** */
            $calculation_formula = $planeid->counter_type/5*3;
            /** */
            if ($event->activity->engine_warmup == true) {
                $warmup_to_apply = round(($event->activity->counter_start-$event->activity->warmup_start)*$calculation_formula, 2);
                $event->activity->warmup_minutes = $warmup_to_apply;
            }
            /** Calculate the offset between counter values */
            $minutes_to_apply = round(($event->activity->counter_stop-$event->activity->counter_start)*$calculation_formula, 2);
            $event->activity->minutes = $minutes_to_apply;
            $event->activity->rate = $rate_to_apply[0];
            $amount_to_apply = $minutes_to_apply*$rate_to_apply[0];
            $event->activity->amount = $amount_to_apply;

            $event->activity->save();
            /** */
        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

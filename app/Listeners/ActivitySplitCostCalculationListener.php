<?php

namespace App\Listeners;

use App\Events\ActivitySplitCostCalculation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivitySplitCostCalculationListener
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
     * @param  ActivitySplitCostCalculation  $event
     * @return void
     */
    public function handle(ActivitySplitCostCalculation $event)
    {
        //
    }
}

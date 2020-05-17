<?php

namespace App\Listeners;

use App\Events\ActivitySplitCost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivitySplitCostListener
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
     * @param  ActivitySplitCost  $event
     * @return void
     */
    public function handle(ActivitySplitCost $event)
    {
        dd('bin hier');
    }
}

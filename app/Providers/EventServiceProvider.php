<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\ActivityCostCalculation' => [
            'App\Listeners\ActivityCostCalculationListener',
        ],
//        'App\Events\BookingEvent' => [
//            'App\Listeners\BookingListener',
//        ],
//        'App\Events\BookingCreatedEvent' => [
//            'App\Listeners\BookingCreatedListener',
//        ],
//        'App\Events\BookingDeletedEvent' => [
//            'App\Listeners\BookingDeletedListener',
//        ],
//        'App\Events\BookingChangedEvent' => [
//            'App\Listeners\BookingChangedListener',
//        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

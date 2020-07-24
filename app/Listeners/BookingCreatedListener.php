<?php

namespace App\Listeners;

use App\Events\BookingCreatedEvent;
use App\Notifications\BookingDataCreateEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Throwable;
use App\User;
use App\Plane;

class BookingCreatedListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(BookingCreatedEvent $event)
    {
        try {
            $users = User::findOrFail($event->booking->user_id);
            $plane = Plane::findOrFail($event->booking->plane_id);

            /** Recipients */
            $admins = User::wherehas('roles', function ($q) {
                $q->where('role_id', User::IS_ADMIN);
            })->get();

            $data  = ['reservation_start' => $event->booking->reservation_start, 'reservation_stop' => $event->booking->reservation_stop];
            Notification::send($users, new BookingDataCreateEmailNotification($data));
            Notification::send($admins, new BookingDataCreateEmailNotification($data));
            return;
        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\BookingDeletedEvent;
use App\Notifications\BookingDeleteAdminNotification;
use App\Notifications\BookingDeleteInstructorNotification;
use App\Notifications\BookingDeleteUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Throwable;
use App\User;
use App\Plane;
use App\Type;
// TODO: switching back to queue
class BookingDeletedListener //implements ShouldQueue
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
     * @param BookingDeletedEvent $event
     * @return void
     */
    public function handle(BookingDeletedEvent $event)
    {
        try {
            $user = User::findOrFail($event->booking->user_id);
            $plane = Plane::findOrFail($event->booking->plane_id);
            $type = Type::findOrFail($event->booking->type_id);
            /** Recipients */
            $admins = User::wherehas('roles', function ($q) {
                $q->where('role_id', User::IS_ADMIN);
            })->get();
            $instructors = User::where('instructor', true)->get();

            Notification::send($user, new BookingDeleteUserNotification($event, $user, $type, $plane));
            Notification::send($admins, new BookingDeleteAdminNotification($event, $user, $type, $plane));

            if ($type->instructor == true) {
                Notification::send($instructors, new BookingDeleteInstructorNotification($event, $user, $type, $plane));
            }
            return;

        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\BookingCreatedEvent;
use App\Notifications\BookingCreateAdminNotification;
use App\Notifications\BookingCreateInstructorNotification;
use App\Notifications\BookingCreateUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Throwable;
use App\User;
use App\Plane;
use App\Type;
// TODO: switching back to queue
class BookingCreatedListener //implements ShouldQueue
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
     * @param BookingCreatedEvent $event
     * @return void
     *
     */
    public function handle(BookingCreatedEvent $event)
    {
        try {
            $user = User::findOrFail($event->booking->user_id);
            $plane = Plane::findOrFail($event->booking->plane_id);
            $type = Type::findOrFail($event->booking->type_id);
            $admins = User::wherehas('roles', function ($q) {
                $q->where('role_id', User::IS_ADMIN);
            })->get();
            $instructors = User::where('instructor', true)->get();

            Notification::send($user, new BookingCreateUserNotification($event, $user, $type, $plane));
            Notification::send($admins, new BookingCreateAdminNotification($event, $user, $type, $plane));

            if ($type->instructor == true && $event->booking->status === 0) {
                Notification::send($instructors, new BookingCreateInstructorNotification($event, $user, $type, $plane));
            }
            return;

        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\BookingChangedEvent;
use App\Notifications\BookingChangeAdminNotification;
use App\Notifications\BookingChangeInstructorNotification;
use App\Notifications\BookingChangeUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Throwable;
use App\User;
use App\Plane;
use App\Type;
// TODO: switching back to queue
class BookingChangedListener //implements ShouldQueue
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
     * @param BookingChangedEvent $event
     * @return void
     *
     */
    public function handle(BookingChangedEvent $event)
    {
        try {
            $user = User::findOrFail($event->booking->user_id);
            $instructor = User::findOrFail($event->booking->instructor_id);
            $plane = Plane::findOrFail($event->booking->plane_id);
            $type = Type::findOrFail($event->booking->type_id);
            $admins = User::wherehas('roles', function ($q) {
                $q->where('role_id', User::IS_ADMIN);
            })->get();
            $instructors = User::where('instructor', true)->get();

            Notification::send($user, new BookingChangeUserNotification($event, $user, $type, $plane, $instructor));
            Notification::send($admins, new BookingChangeAdminNotification($event, $user, $type, $plane, $instructor));

            if ($type->instructor == true && $event->booking->status == 1) {
                Notification::send($instructors, new BookingChangeInstructorNotification($event, $user, $type, $plane, $instructor));
            }
            return;

        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

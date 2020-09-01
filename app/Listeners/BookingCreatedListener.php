<?php

namespace App\Listeners;

use App\Events\BookingCreatedEvent;
use App\Notifications\BookingCreateAdminNotification;
use App\Notifications\BookingCreateInstructorNotification;
use App\Notifications\BookingCreateUserNotification;
use http\Env\Url;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Throwable;
use App\User;
use App\Plane;
use App\Type;
use Grosv\LaravelPasswordlessLogin\LoginUrl;

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
     * @param BookingCreatedEvent $event
     * @return void
     *
     */
    public function handle(BookingCreatedEvent $event)
    {
        try {
            $redirect_url = url('/admin/bookings/'. $event->booking->id .'/edit');
            $plane = Plane::findOrFail($event->booking->plane_id);
            $type = Type::findOrFail($event->booking->type_id);

            $user = User::findOrFail($event->booking->user_id);
//            $generator_user = new LoginUrl($user);
//            $generator_user->setRedirectUrl($redirect_url);
//            $user_url = $generator_user->generate();
            $user_url = $redirect_url;
            Notification::send($user, new BookingCreateUserNotification($event, $user, $type, $plane, $user_url));

            // For admins
            $admins = User::wherehas('roles', function ($q) {
                $q->where('role_id', User::IS_ADMIN);
            })->get();
            foreach ($admins as $admin) {
//                $generator_admin = new LoginUrl($admin);
//                $generator_admin->setRedirectUrl($redirect_url);
//                $admin_url = $generator_admin->generate();
                $admin_url = $redirect_url;
                Notification::send($admin, new BookingCreateAdminNotification($event, $user, $type, $plane, $admin_url));
            }

            //For instructors
            if ($type->instructor == true && $event->booking->status == 0) {
                $instructors = User::where('instructor', true)->get();
                foreach ($instructors as $instructor) {
//                    $generator_instructor = new LoginUrl($instructor);
//                    $generator_instructor->setRedirectUrl($redirect_url);
//                    $instructor_url = $generator_instructor->generate();
                    $instructor_url = $redirect_url;
                    Notification::send($instructor, new BookingCreateInstructorNotification($event, $user, $type, $plane, $instructor_url));
                }
            }

            return;

        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

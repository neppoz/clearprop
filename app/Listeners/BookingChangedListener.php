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
use Grosv\LaravelPasswordlessLogin\LoginUrl;

class BookingChangedListener implements ShouldQueue
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
            $redirect_url = '/admin/bookings/'. $event->booking->id .'/edit';
            $plane = Plane::findOrFail($event->booking->plane_id);
            $type = Type::findOrFail($event->booking->type_id);
            $instructor = User::findOrFail($event->booking->instructor_id);

            $user = User::findOrFail($event->booking->user_id);
//            $generator_user = new LoginUrl($user);
//            $generator_user->setRedirectUrl($redirect_url);
//            $user_url = $generator_user->generate();
            $user_url = $redirect_url;
            Notification::send($user, new BookingChangeUserNotification($event, $user, $type, $plane, $instructor, $user_url));

            // For admins
            $admins = User::wherehas('roles', function ($q) {
                $q->where('role_id', User::IS_ADMIN);
            })->get();
            foreach ($admins as $admin) {
//                $generator_admin = new LoginUrl($admin);
//                $generator_admin->setRedirectUrl($redirect_url);
//                $admin_url = $generator_admin->generate();
                $admin_url = $redirect_url;
                Notification::send($admin, new BookingChangeAdminNotification($event, $user, $type, $plane, $instructor, $admin_url));
            }

            //For instructors
            if ($type->instructor == true && $event->booking->status == 1) {
                $instructors = User::where('instructor', true)->get();
                foreach ($instructors as $instructor) {
//                    $generator_instructor = new LoginUrl($instructor);
//                    $generator_instructor->setRedirectUrl($redirect_url);
//                    $instructor_url = $generator_instructor->generate();
                    $instructor_url = $redirect_url;
                    Notification::send($instructor, new BookingChangeInstructorNotification($event, $user, $type, $plane, $instructor, $instructor_url));
                }
            }

            return;
        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

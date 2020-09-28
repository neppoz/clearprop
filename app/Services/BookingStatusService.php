<?php


namespace App\Services;

use App\Notifications\BookingConfirmedNotification;
use App\User;
use App\Booking;
use Illuminate\Support\Facades\Notification;

class BookingStatusService
{
    public function createStatus($booking)
    {
        $booking->load('user', 'instructor', 'plane', 'created_by');
        try {
            if ($booking->instructor_needed == true) {
                // set status to pending
                $booking->status = 0;
                $booking->save();

            } else {
                // Auto-Confirmation, status 1
                $booking->status = 1;
                $booking->save();

//                $this->sendNotificationsConfirmed($booking);
            }
            return true;

        } catch (\Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }

    }

    public function updateStatus($booking)
    {
        $booking->load('user', 'instructor', 'plane', 'created_by');
        if ($booking->status == 1 && Booking::MODUS_SELECT[$booking->modus] == 'pilot') {
            $this->sendNotificationsConfirmed($booking);
        }

        return true;
    }

    public function sendNotificationsConfirmed($booking) {

        Notification::send($booking->user, new BookingConfirmedNotification($booking));

        $managers = User::wherehas('roles', function ($q) {
            $q->where('role_id', User::IS_MANAGER);
        })->get();
        foreach ($managers as $manager) {
            Notification::send($manager, new BookingConfirmedNotification($booking));
        }

        if (!empty($booking->instructor->name)) {
            Notification::send($booking->instructor, new BookingConfirmedNotification($booking));
        }

        return true;
    }

//    public function sendNotificationsPending($booking, $type, $redirect_url, $plane, $user) {
//
//        return true;
//    }
}

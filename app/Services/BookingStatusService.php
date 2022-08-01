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
        try {
            if ($booking->instructor_needed == true) {
                // set status to pending
                $booking->status = 0;
            } else {
                // Auto-Confirmation, status 1
                $booking->status = 1;
            }

            $booking->bookingUsers()->attach(auth()->user()->id);
            $booking->created_by_id = auth()->user()->id;
            $booking->save();

            return true;

        } catch (\Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }

    }

    public function sendNotificationsConfirmed($booking) {

        Notification::send($booking->user, new BookingConfirmedNotification($booking));

        if (!empty($booking->instructor->name)) {
            Notification::send($booking->instructor, new BookingConfirmedNotification($booking));
        }

        return true;
    }

}

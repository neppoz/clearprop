<?php


namespace App\Services;

use App\Notifications\BookingConfirmedNotification;
use App\User;
use App\Booking;
use Illuminate\Support\Facades\Notification;

class BookingNotificationService
{
    public function sendNotificationsConfirmed($booking)
    {

        $booking->load('bookingUsers', 'bookingInstructors');

        if (count($booking->bookingUsers)) {
            foreach ($booking->bookingUsers as $user) {
                Notification::send($user, new BookingConfirmedNotification($booking));
            }
        }

        if (count($booking->bookingInstructors)) {
            foreach ($booking->bookingInstructors as $user) {
                Notification::send($user, new BookingConfirmedNotification($booking));
            }
        }

        $managers = User::wherehas('roles', function ($q) {
            $q->where('role_id', User::IS_MANAGER);
        })->get();
        foreach ($managers as $manager) {
            Notification::send($manager, new BookingConfirmedNotification($booking));
        }

        return true;
    }

}

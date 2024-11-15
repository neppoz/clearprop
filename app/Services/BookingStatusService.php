<?php


namespace App\Services;

use App\Notifications\BookingConfirmedNotification;
use App\User;
use App\Booking;
use Illuminate\Support\Facades\Notification;

class BookingStatusService
{
//    public function createStatus($request, $booking)
//    {
//        if ($request->input('status') != null) {
//            $booking->status = $request->status;
//        } else {
//            // Auto-Confirmation, status 1 if no valid input
//            $booking->status = 1;
//        }
//        if ($booking->instructor_needed == true) {
//            // set status to pending by default in this condition
//            $booking->status = 0;
//        }
//        $booking->bookingUsers()->attach($request->user_id);
//        $booking->created_by_id = auth()->user()->id;
//        $booking->save();
//
//        return true;
//    }
//
//    public function sendNotificationsConfirmed($booking) {
//
//        Notification::send($booking->user, new BookingConfirmedNotification($booking));
//
//        if (!empty($booking->instructor->name)) {
//            Notification::send($booking->instructor, new BookingConfirmedNotification($booking));
//        }
//
//        return true;
//    }

}

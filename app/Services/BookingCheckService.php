<?php

namespace App\Services;

use App\Booking;
use App\Plane;
use App\Parameter;

use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingCheckService
{
    public function calculateSeatsCheckIn(Booking $booking)
    {

    }

    public function decrementSeats(Booking $booking)
    {
        try {
            $booking->bookingUsers()->attach(auth()->user()->id);
            $booking->seats_available = $booking->seats_available - 1;
            $booking->save();

            return true;

        } catch (\Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }

    }

    public function incrementSeats(Booking $booking)
    {
        try {
            $booking->bookingUsers()->detach(auth()->user()->id);
            $booking->seats_available = $booking->seats_available + 1;
            $booking->save();

            return true;

        } catch (\Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}

<?php

namespace App\Services;

use App\Booking;
use App\Plane;
use App\Parameter;

use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingCheckService
{
    public function availabilityCheckPassed(Request $request)
    {
        try {
            $times = [
                Carbon::createFromFormat('d/m/Y H:i', $request->reservation_start)->addSeconds(1),
                Carbon::createFromFormat('d/m/Y H:i', $request->reservation_stop)->subSeconds(1),
            ];
//            debug($times);
            /** This query returns:
             *  0 if plane is not available
             *  1 if plane is available (you can book it)
             */
            $planeReservationQuery = Plane::where('id', '=', $request->plane_id)
                ->whereDoesntHave('planeBookings', function ($query) use ($times) {
                    $query->whereBetween('reservation_start', $times)
                        ->orWhereBetween('reservation_stop', $times)
                        ->orWhere(function ($query) use ($times) {
                            $query->where('reservation_start', '<', $times[0])
                                ->where('reservation_stop', '>', $times[1]);
                        });
                })->count();

            if ($planeReservationQuery == 1) {
                return true;
            }
        } catch (\Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
        return false;
    }

    public function calculateCheckIn(Booking $booking)
    {
        $booking->seats_taken = $booking->bookingUsers()->count();
    }

    public function decrementSeats(Request $request)
    {

    }

    public function incrementSeats(Request $request)
    {

    }
}

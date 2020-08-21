<?php


namespace App\Services;

use App\Type;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingStatusService
{
    public function createStatus($booking)
    {
        $type = Type::findOrFail($booking->type_id);
        try {
            if ($type->instructor == true) {
                $booking->setStatus('pending', 'Instructor');
            }
            if ($type->instructor == false) {
                $booking->setStatus('confirmed', 'Regular');
            }
            return true;
        } catch (\Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }

    }
}

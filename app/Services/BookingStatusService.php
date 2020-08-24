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
                // set status to pending
                $booking->status = 0;
                $booking->save();
            } else {
                // Auto-Confirmation, status 1
                $booking->status = 1;
                $booking->save();
            }
            return true;
        } catch (\Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }

    }
}

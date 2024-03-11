<?php

namespace App\Services;

use App\Booking;
use Carbon\Carbon;

class BookingDataService
{
    public function getBookingDataForCalendar(): bool|string
    {
        $collectionBookingEvents = [];

        $bookingDates = Booking::with(['plane', 'bookingUsers', 'bookingInstructors', 'slot', 'mode'])
            ->orderBy('reservation_start', 'asc')
            ->get();

        foreach ($bookingDates as $bookingDateItem) {
            switch ($bookingDateItem->mode_id) {
                case('1'):
                    $borderColor = "#007bff";
                    $backgroundColor = "#007bff";
                    break;
                case('2'):
                    $borderColor = "#6c757d";
                    $backgroundColor = "#6c757d";
                    break;
                case('4'):
                    $borderColor = "#dc3545";
                    $backgroundColor = "#dc3545";
                    break;
                default:
                    $borderColor = "#007bff";
                    $backgroundColor = "#007bff";
            }

            $collectionBookingEvents[] = [
                'title' => $bookingDateItem->plane->callsign,
                'start' => Carbon::createFromFormat('d/m/Y H:i', $bookingDateItem->reservation_start)->format('Y-m-d H:m'),
                'end' => Carbon::createFromFormat('d/m/Y H:i', $bookingDateItem->reservation_stop)->format('Y-m-d H:m'),
                'backgroundColor' => $backgroundColor,
                'borderColor' => $borderColor,
                'description' => $bookingDateItem->description,
            ];
        }
        return json_encode($collectionBookingEvents);
    }

    public function getBookingDataForCards(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Booking::with(['plane', 'bookingUsers', 'bookingInstructors', 'slot', 'mode'])
            ->where('reservation_stop', '>=', Carbon::parse(today()))
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('ddd DD MMM');
            });
    }

}

<?php

namespace App\Http\Controllers\Pilot;

use App\Booking;
use App\Services\StatisticsService;
use App\Slot;
use Illuminate\Support\Str;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);

        $bookingDates = Booking::with(['plane', 'bookingUsers', 'bookingInstructors', 'slot', 'mode'])
            ->where('reservation_start', '>=', Carbon::parse(today()))
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('ddd DD MMM');
            });

        $checkinDates = Booking::with(['plane', 'bookingUsers', 'bookingInstructors', 'slot'])
            ->whereDoesntHave('bookingUsers', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('reservation_start', '>=', Carbon::parse(today()))
            ->where('checkin', 1)
            ->where('seats_available', '>', 0)
            ->where('status', 1)
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return $booking->slot->title . ' - ' . Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('dddd, DD MMMM YYYY');
            });

        return view('welcome', compact('statistics', 'bookingDates', 'checkinDates'));
    }

}

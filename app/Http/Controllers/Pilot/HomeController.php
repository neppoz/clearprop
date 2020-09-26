<?php

namespace App\Http\Controllers\Pilot;

use App\Booking;
use App\Services\StatisticsService;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);

        $bookingsDates = Booking::with(['plane', 'user', 'instructor'])
            ->where('reservation_start', '>=', Carbon::parse(today()))
//            ->where('user_id', Auth()->user()->id)
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('dddd, DD MMMM YYYY');
            });

        $slotDates = Booking::with(['plane', 'user', 'instructor'])
            ->where('reservation_start', '>=', Carbon::parse(today()))
            ->where('modus', 1)
            ->where('status', 0)
            ->whereNull('user_id')
//            ->where('user_id', Auth()->user()->id)
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('dddd, DD MMMM YYYY');
            });

        return view('welcome', compact('statistics', 'bookingsDates', 'slotDates'));
    }

}

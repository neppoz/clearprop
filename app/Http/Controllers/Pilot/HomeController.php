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
            ->where('reservation_start', '>=', Carbon::parse(now())->subDays(1))
            ->where('user_id', Auth()->user()->id)
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->reservation_start)->localeDayOfWeek . ', ' . Carbon::parse($booking->reservation_start)->format(config('panel.date_format'));
            });

        return view('welcome', compact('statistics', 'bookingsDates'));
    }
}

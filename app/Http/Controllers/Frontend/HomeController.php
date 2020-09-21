<?php

namespace App\Http\Controllers\Frontend;

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

        $bookings = Booking::where('reservation_start', '>=', Carbon::parse(now()))
            ->where('user_id', auth()->user()->id)
            ->orderBy('reservation_start')
            ->get();

        return view('welcome', compact('statistics', 'bookings'));
    }
}

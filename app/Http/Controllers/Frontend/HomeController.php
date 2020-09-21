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

        $bookings = Booking::with(['plane', 'user', 'instructor'])
            ->where('reservation_start', '>=', Carbon::parse(now()))
            ->where('user_id', Auth()->user()->id)
            ->orderBy('reservation_start')
            ->get();

        $bookings->load('plane', 'user');

        return view('welcome', compact('statistics', 'bookings'));
    }
}

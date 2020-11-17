<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Services\NotificationService;
use App\Services\StatisticsService;
use App\User;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomeController
{
    public function index(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);

        $bookings = Booking::with(['plane', 'bookingUsers', 'bookingInstructors'])
            ->where('reservation_start', '>=', Carbon::parse(today()))
            ->orderBy('reservation_start')
            ->get();

        $userMedicals = User::whereNotNull('medical_due')
            ->orderBy('medical_due', 'desc')
            ->get();

        return view('home', compact('statistics', 'bookings', 'userMedicals'));
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Services\StatisticsService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);

        $userMedicalGoingDue = User::whereNotNull('medical_due')
            ->whereBetween('medical_due', [Carbon::now(), Carbon::now()->addWeeks(4)])
            ->orderBy('medical_due', 'desc')
            ->get();

        return view('home', compact('statistics', 'userMedicalGoingDue'));
    }

}

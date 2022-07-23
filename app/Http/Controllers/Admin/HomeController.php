<?php

namespace App\Http\Controllers\Admin;

use App\Parameter;
use App\Services\StatisticsService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            $userMedicalGoingDue = User::whereNotNull('medical_due')
                ->whereBetween('medical_due', [Carbon::now(), Carbon::now()->addDays(40)])
                ->orWhere('medical_due', '<', [Carbon::now(), Carbon::now()])
                ->orderBy('medical_due', 'desc')
                ->get();
        } else {
            $userMedicalGoingDue = '';
        }

        return view('home', compact('statistics', 'userMedicalGoingDue'));
    }

}

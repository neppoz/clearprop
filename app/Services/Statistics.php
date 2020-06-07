<?php

namespace App\Services;

use App\Activity;
use App\Income;

class Statistics {

    public function dashboard() {

        $activity_lines = Activity::select('event', 'counter_start', 'counter_stop', 'rate', 'minutes', 'amount')
            ->when(auth()->user()->roles->contains(1) !=true, function ($query) {
                return $query->where('user_id', auth()->id());
            })->get();

        $activityAmountTotal = $activity_lines->sum('amount');
        $activityMinutesTotal = $activity_lines->sum('minutes');
        $activityHoursAndMinutes = intval($activityMinutesTotal / 60) . 'h : ' . $activityMinutesTotal%60 . 'm';

        $income_lines = Income::whereHas('income_category', function ($q) {
            $q->where('deposit', '=', 1);
            })
            ->when(auth()->user()->roles->contains(1) !=true, function ($query) {
                return $query->where('user_id', auth()->id());
            })->get();

        $incomeAmountTotal = $income_lines->sum('amount');

        $granTotal = $incomeAmountTotal + -abs($activityAmountTotal);

        return compact('granTotal', 'incomeAmountTotal', 'activityAmountTotal', 'activityHoursAndMinutes');

    }
}

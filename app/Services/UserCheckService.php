<?php

namespace App\Services;

use App\Activity;
use App\Income;
use App\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Throwable;

class UserCheckService
{
    public function medicalCheckPassed(User $user)
    {
        if (!empty($user->medical_due) && Carbon::createFromFormat(config('panel.date_format'), $user->medical_due)->format('Y-m-d') <=  now()) {
            return false;
        }
        return true;
    }

    public function balanceCheckPassed(User $user)
    {
        $activities = Activity::where('user_id', $user->id)
                ->whereBetween('event', [now()->startOfYear(), now()]);

        $incomes = Income::whereHas('income_category', function ($q) {
            $q->where('deposit', '=', 1);
        })
            ->where('user_id', $user->id)
            ->whereBetween('entry_date', [now()->startOfYear(), now()]);

        if (($activities->sum('amount')-abs($incomes->sum('amount'))) > 0) {
            return false;
        }

        return true;
    }

    public function activityCheckPassed(User $user)
    {
        return true;
    }
}

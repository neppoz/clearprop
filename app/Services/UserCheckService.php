<?php

namespace App\Services;

use App\Activity;
use App\Income;
use App\User;
use Carbon\Carbon;
use App\Parameter;

use Illuminate\Http\Request;
use Throwable;

class UserCheckService
{
    public function medicalCheckPassed(User $user)
    {
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            if (!empty($user->medical_due) && Carbon::createFromFormat(config('panel.date_format'), $user->medical_due)->format('Y-m-d') <=  now()) {
                return false;
            }
        }
        return true;
    }

    public function balanceCheckPassed(User $user)
    {
        if (Parameter::where('slug', 'check.balance')->value('value') == Parameter::CHECK_BALANCE_ENABLED) {
            $activities = Activity::where('user_id', $user->id)
                ->whereBetween('event', [now()->startOfYear(), now()])
                ->get('amount');

            $incomes = Income::whereHas('income_category', function ($q) {
                $q->where('deposit', '=', 1);
            })
                ->where('user_id', $user->id)
                ->whereBetween('entry_date', [now()->startOfYear(), now()])
                ->get('amount');

            $balance = ($incomes->sum('amount')-abs($activities->sum('amount')));
            if ($balance <= Parameter::where('slug', 'check.balance.limit.amount')->value('value')) {
                return false;
            }
        }
        return true;
    }

    public function activityCheckPassed(User $user)
    {
        if (Parameter::where('slug', 'check.activities')->value('value') == Parameter::CHECK_ACTIVITIES_ENABLED) {
            $activities = Activity::where('user_id', $user->id)
                ->whereBetween('event', [now()->startOfYear(), now()])
                ->orderBy('event', 'DESC')
                ->first('event');

            $expDate = Carbon::now()->subDays(Parameter::where('slug', 'check.activities.limit.days')->value('value'));
            if (Carbon::createFromFormat(config('panel.date_format'), $activities->event)->format('Y-m-d') <= $expDate) {
                return false;
            }
        }
        return true;
    }
}

<?php

namespace App\Services;

use App\Activity;
use App\Income;
use App\Plane;
use App\User;
use Carbon\Carbon;
use App\Parameter;

use Illuminate\Http\Request;
use Throwable;

class UserCheckService
{
    public function medicalCheckPassed(User $user): bool
    {
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            if (empty($user->medical_due)) {
                return false;
            }
            if (!empty($user->medical_due) && Carbon::createFromFormat(config('panel.date_format'), $user->medical_due)->format('Y-m-d') <= now()) {
                return false;
            }
        }
        return true;
    }

    public function balanceCheckPassed(User $user): bool
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

            $balance = ($incomes->sum('amount') - abs($activities->sum('amount')));
            //debug("Incomes: " . $incomes->sum('amount') . "\t Activities: " . $activities->sum('amount'));
            if ($balance <= Parameter::where('slug', 'check.balance.limit.amount')->value('value')) {
                return false;
            }

        }
        return true;
    }

    public function activityCheckPassed(User $user, Plane $plane): bool
    {
        if (Parameter::where('slug', 'check.activities')->value('value') == Parameter::CHECK_ACTIVITIES_ENABLED) {
            $activities = Activity::where('user_id', $user->id)
                ->where('plane_id', $plane->id)
                ->orderBy('event', 'DESC')
                ->first('event');

            if (!empty($activities->event)) {
                $expDate = Carbon::now()->subDays(Parameter::where('slug', 'check.activities.limit.days')->value('value'));
                if (Carbon::createFromFormat(config('panel.date_format'), $activities->event)->format('Y-m-d') <= $expDate) {
                    return false;
                }
            }
            return true;
        }
        return true;
    }

    public function ratingCheckPassed(User $user, Plane $plane): bool
    {
        if (Parameter::where('slug', 'check.ratings')->value('value') == Parameter::CHECK_RATINGS_ENABLED) {
            if ($user->planes()->where('plane_id', $plane->id)->exists()) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}

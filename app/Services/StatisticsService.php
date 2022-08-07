<?php

namespace App\Services;

use App\Activity;
use App\Asset;
use App\Income;
use App\Expense;
use App\Parameter;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gate;
use Illuminate\Support\Facades\Log;

class StatisticsService
{
    public function dashboard(Request $request)
    {
        // Call the function
        $activity_lines = $this->getActivitiesCurrentYear();

        $activityAmountTotal = $activity_lines->sum('amount');
        $activityMinutesTotal = $activity_lines->sum('minutes');
        $activityHoursAndMinutes = sprintf("%02d", intval($activityMinutesTotal / 60)) . 'h : ' . sprintf("%02d", $activityMinutesTotal % 60) . 'm';

        // Call the function
        $income_lines = $this->getDepositIncomesCurrentYear();
        $incomeAmountTotal = $income_lines->sum('amount');
        $granTotal = $incomeAmountTotal + -abs($activityAmountTotal);

        // Call the function
        $assetsOverhaulData = $this->getAssetsOverhaulData();

        return compact('granTotal', 'incomeAmountTotal', 'activityAmountTotal', 'activityHoursAndMinutes', 'assetsOverhaulData');
    }

    public function getUsersMedicalDue($request)
    {
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            if (Gate::allows('user_edit')) {
                $userMedicalGoingDue = User::withoutGlobalScopes()
                    ->whereNotNull('medical_due');

                $userMedicalDueInFuture = $userMedicalGoingDue->whereBetween('medical_due', [Carbon::now(), Carbon::now()->addDays(30)])->count();
                $userMedicalIsAlreadyDue = $userMedicalGoingDue->where('medical_due', '<=', [Carbon::now(), Carbon::now()])->count();

                return ['userMedicalDueInFuture' => $userMedicalDueInFuture ?? 0, 'userMedicalIsAlreadyDue' => $userMedicalIsAlreadyDue ?? 0];
            }

            if (Gate::denies('user_edit')) {
                $userMedicalGoingDue = Auth::user()->whereNotNull('medical_due');

                $userMedicalDueInFuture = $userMedicalGoingDue->whereBetween('medical_due', [Carbon::now(), Carbon::now()->addDays(30)])->get();
                $userMedicalIsAlreadyDue = $userMedicalGoingDue->where('medical_due', '<=', [Carbon::now(), Carbon::now()])->count();

                return ['userMedicalDueInFuture' => $userMedicalDueInFuture ?? 0, 'userMedicalIsAlreadyDue' => $userMedicalIsAlreadyDue ?? 0];
            }
        }

        return false;
    }

    public function getCurrentUserMedicalDue($request)
    {
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            $currentUserMedicalGoingDue = Auth::user()->whereNotNull('medical_due');

            $currentUserMedicalDueInFuture = $currentUserMedicalGoingDue->whereBetween('medical_due', [Carbon::now(), Carbon::now()->addDays(30)])->get();
            $currentUserMedicalIsAlreadyDue = $currentUserMedicalGoingDue->where('medical_due', '<=', [Carbon::now(), Carbon::now()])->count();

            return ['currentUserMedicalDueInFuture' => $currentUserMedicalDueInFuture ?? 0, 'currentUserMedicalIsAlreadyDue' => $currentUserMedicalIsAlreadyDue ?? 0];
        }
    }

    public function getAssetsOverhaulData()
    {
        $activeAssetsWithPlane = Asset::with('plane')->where('status_id', 1)->whereNotNull('plane_id');
        $activeAssetsGroupedByPlane = $activeAssetsWithPlane->get()->groupBy('plane.callsign');

        foreach ($activeAssetsGroupedByPlane as $plane => $assets) {
            foreach ($assets as $asset) {
                $asset->daysUntilDueDate = Carbon::createFromFormat(config('panel.date_format'), $asset->end_date ?? 0)->longAbsoluteDiffForHumans();
                $asset->hoursUntilOverhaul = $asset->end_hours - ($asset->start_hours + $asset->current_running_hours);

                $assetActualRunningHours = $asset->start_hours + $asset->current_running_hours;

                if ($assetActualRunningHours > 0) {
                    $asset->progressBarInPercent = $assetActualRunningHours / $asset->end_hours * 100;
                } else {
                    $asset->progressBarInPercent = 0;
                }

                if ($asset->progressBarInPercent <= 50) {
                    $asset->progressBarColor = 'info';
                } elseif ($asset->progressBarInPercent >= 50 && $asset->progressBarInPercent <= 80) {
                    $asset->progressBarColor = 'warning';
                } elseif ($asset->progressBarInPercent >= 80) {
                    $asset->progressBarColor = 'danger';
                }
            }
        }

        return $activeAssetsGroupedByPlane;

    }

    public function getActivitiesCurrentYear()
    {
        return Activity::with([
            'user' => function ($q) {
                $q->withTrashed()->select('id', 'name');
            },
            'type' => function ($q) {
                $q->withTrashed()->select('id', 'name');
            },
            'plane' => function ($q) {
                $q->withTrashed()->select('id', 'callsign');
            },
            'instructor' => function ($q) {
                $q->withTrashed()->select('id', 'name');
            },
        ])->whereBetween('event', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

    public function getActivitiesByFilter($fromDate, $toDate)
    {
        return Activity::with([
            'user' => function ($q) {
                $q->withTrashed()->select('id', 'name');
            },
            'type' => function ($q) {
                $q->withTrashed()->select('id', 'name');
            },
            'plane' => function ($q) {
                $q->withTrashed()->select('id', 'callsign');
            },
            'instructor' => function ($q) {
                $q->withTrashed()->select('id', 'name');
            },
        ])->whereBetween('event', [$fromDate, $toDate]);
    }

    public function getActivitiesAllTime()
    {
        return Activity::all();
    }

    public function getActivityReport($fromDate, $toDate)
    {
        /** Call the function
         *  CAVE: when calling the activities, the filter will be enlarged for every call.
         *  So therefore the order of the sum is crucial
         * */
        $activities = $this->getActivitiesByFilter($fromDate, $toDate);

        $activityTotalMinutes = $activities->sum('minutes');
        $activityTotalTime = sprintf("%02d", intval($activityTotalMinutes / 60)) . ':' . sprintf("%02d", $activityTotalMinutes % 60);

        /* Activity by member */
        $groupedUserActivities = $activities->whereNotNull('user_id')->orderBy('minutes', 'desc')->get()->groupBy('user_id');
        $activitiesUserSummary = [];

        foreach ($groupedUserActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesUserSummary[$line->user->name])) {
                    $activitiesUserSummary[$line->user->name] = [
                        'name'   => $line->user->name,
                        'minutes' => 0
                    ];
                }
                $activitiesUserSummary[$line->user->name]['minutes'] += $line->minutes;

            }

        }


        /* Activity by type */
        $groupedTypeActivities = $activities->whereNotNull('type_id')->orderBy('minutes', 'desc')->get()->groupBy('type_id');
        $activitiesTypeSummary = [];

        foreach ($groupedTypeActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesTypeSummary[$line->type->name])) {
                    $activitiesTypeSummary[$line->type->name] = [
                        'name'   => $line->type->name,
                        'minutes' => 0,
                    ];
                }

                $activitiesTypeSummary[$line->type->name]['minutes'] += $line->minutes;
            }
        }

        /* Activity by plane */
        $groupedPlaneActivities = $activities->whereNotNull('plane_id')->orderBy('minutes', 'desc')->get()->groupBy('plane_id');
        $activitiesPlaneSummary = [];

        foreach ($groupedPlaneActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesPlaneSummary[$line->plane->callsign])) {
                    $activitiesPlaneSummary[$line->plane->callsign] = [
                        'callsign'   => $line->plane->callsign,
                        'minutes' => 0,
                    ];
                }

                $activitiesPlaneSummary[$line->plane->callsign]['minutes'] += $line->minutes;
            }
        }

        /* Activity by instructor */
        $groupedInstructorActivities = $activities->whereNotNull('instructor_id')->orderBy('minutes', 'desc')->get()->groupBy('instructor_id');
        $activitiesInstructorSummary = [];

        foreach ($groupedInstructorActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesInstructorSummary[$line->instructor->name])) {
                    $activitiesInstructorSummary[$line->instructor->name] = [
                        'name'   => $line->instructor->name,
                        'minutes' => 0
                    ];
                }

                $activitiesInstructorSummary[$line->instructor->name]['minutes'] += $line->minutes;
            }
        }

        return [
            'activitiesUserSummary' => $activitiesUserSummary,
            'activitiesInstructorSummary' => $activitiesInstructorSummary,
            'activitiesTypeSummary' => $activitiesTypeSummary,
            'activitiesPlaneSummary' => $activitiesPlaneSummary,
            'activityTotalMinutes' => $activityTotalMinutes,
            'activityTotalTime' => $activityTotalTime
        ];
    }

    public function getDepositIncomesCurrentYear()
    {
        return Income::whereHas('income_category', function ($q) {
            $q->where('deposit', '=', 1);
        })
            ->whereBetween('entry_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

    public function getIncomesCurrentYear(Request $request)
    {
        return Income::with('income_category')
            ->whereBetween('entry_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

    public function getIncomesByFilter($fromDate, $toDate)
    {
        return Income::with('income_category')
            ->whereBetween('entry_date', [$fromDate, $toDate]);
    }

    public function getExpensesCurrentYear(Request $request)
    {
        return Expense::with('expense_category')
            ->whereBetween('entry_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

    public function getExpensesByFilter($fromDate, $toDate)
    {
        return Expense::with('expense_category')
            ->whereBetween('entry_date', [$fromDate, $toDate]);
    }

    public function getExpenseReport($fromDate, $toDate)
    {
        // Call the functions
        $expenses = $this->getExpensesByFilter($fromDate, $toDate);
        $incomes = $this->getIncomesByFilter($fromDate, $toDate);

        $expensesTotal = $expenses->sum('amount');
        $incomesTotal = $incomes->sum('amount');
        $groupedExpenses = $expenses->whereNotNull('expense_category_id')->orderBy('amount', 'desc')->get()->groupBy('expense_category_id');
        $groupedIncomes = $incomes->whereNotNull('income_category_id')->orderBy('amount', 'desc')->get()->groupBy('income_category_id');
        $profit = $incomesTotal - $expensesTotal;

        $expensesSummary = [];

        foreach ($groupedExpenses as $exp) {
            foreach ($exp as $line) {
                if (!isset($expensesSummary[$line->expense_category->name])) {
                    $expensesSummary[$line->expense_category->name] = [
                        'name' => $line->expense_category->name,
                        'amount' => 0,
                    ];
                }

                $expensesSummary[$line->expense_category->name]['amount'] += $line->amount;
            }
        }

        $incomesSummary = [];

        foreach ($groupedIncomes as $inc) {
            foreach ($inc as $line) {
                if (!isset($incomesSummary[$line->income_category->name])) {
                    $incomesSummary[$line->income_category->name] = [
                        'name' => $line->income_category->name,
                        'amount' => 0,
                    ];
                }

                $incomesSummary[$line->income_category->name]['amount'] += $line->amount;
            }
        }

        /* Overdue payment members */
        $overdueMembers = DB::select(DB::raw("
        SELECT
            u.id,
            u.name,
            COALESCE(suminc, 0) AS suminc,
            COALESCE(sumact, 0) AS sumact,
            COALESCE(suminc, 0) - COALESCE(sumact, 0) AS total
        FROM
            users u
                LEFT JOIN
            (SELECT
                user_id, SUM(amount) AS sumact
            FROM
                activities a
            WHERE
                a.event BETWEEN (:activityfrom) AND (:activityto) AND a.deleted_at is null
            GROUP BY a.user_id) a ON u.id = a.user_id
                LEFT JOIN
            (SELECT
                user_id, SUM(amount) AS suminc
            FROM
                incomes i
            INNER JOIN income_categories ic ON i.income_category_id = ic.id
            WHERE
                i.entry_date BETWEEN (:incomefrom) AND (:incometo)
                    AND ic.deposit = 1 AND i.deleted_at is null
            GROUP BY i.user_id) i ON u.id = i.user_id
        ORDER BY total ASC
        "), array(
            'activityfrom' => $fromDate,
            'activityto' => $toDate,
            'incomefrom' => $fromDate,
            'incometo' => $toDate
        ));

        return [
            'expensesSummary' => $expensesSummary,
            'incomesSummary' => $incomesSummary,
            'expensesTotal' => $expensesTotal,
            'incomesTotal' => $incomesTotal,
            'profit' => $profit,
            'overdueMembers' => $overdueMembers,
            'fromSelectedDate' => $fromDate,
            'toSelectedDate' => $toDate

        ];
    }

}

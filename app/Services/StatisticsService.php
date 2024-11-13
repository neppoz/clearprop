<?php

namespace App\Services;

use App\Models\Activity;

//use App\Asset;
//use App\Income;
//use App\Expense;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Mode;
use App\Models\Parameter;
use App\Models\Plane;
use App\Models\Reservation;

//use App\Parameter;
//use App\User;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gate;
use Illuminate\Support\Facades\Log;

class StatisticsService
{
    public function getGlobalActivityStatistics(): array
    {
        $getActivityDataWithoutScope = $this->getActivityStatisticsCurrentYear()->withoutGlobalScope('user_id')->get();

        return [
            'id' => 'global',
            'name' => trans('cruds.dashboard.statistics.global'),
            'sum' => $getActivityDataWithoutScope->sum('minutes') ?? 0,
            'avg' => $getActivityDataWithoutScope->avg('minutes') ?? 0,
            'count' => $getActivityDataWithoutScope->count() ?? 0,
        ];
    }

    public function getActivityStatisticsCurrentYear(): \Illuminate\Database\Eloquent\Builder|Activity|Builder
    {
        return Activity::whereBetween('event', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

    public function getInstructorActivityStatistics(): array
    {
        $getActivityDataWithoutScope = $this->getActivityStatisticsCurrentYear()->withoutGlobalScope('user_id')->where('instructor_id', Auth::id())->get();

        return [
            'id' => 'instructor',
            'name' => trans('cruds.dashboard.statistics.instructor'),
            'sum' => $getActivityDataWithoutScope->sum('minutes') ?? 0,
            'avg' => $getActivityDataWithoutScope->avg('minutes') ?? 0,
            'count' => $getActivityDataWithoutScope->count() ?? 0,
        ];
    }

    public function getPersonalActivityStatistics(): array
    {
        $getActivityDataWithoutScope = $this->getActivityStatisticsCurrentYear()->withoutGlobalScope('user_id')->where('user_id', Auth::id())->get();

        return [
            'id' => 'personal',
            'name' => trans('cruds.dashboard.statistics.personal'),
            'sum' => $getActivityDataWithoutScope->sum('minutes') ?? 0,
            'avg' => $getActivityDataWithoutScope->avg('minutes') ?? 0,
            'count' => $getActivityDataWithoutScope->count() ?? 0,
        ];
    }

    public function getPersonalFinanceStatistics(): array
    {
        $getActivityDataWithoutScope = $this->getActivityStatisticsCurrentYear()->withoutGlobalScope('user_id')->where('user_id', Auth::id())->get();
        $getPaymentDataWithoutScope = $this->getPaymentsCurrentYear()->withoutGlobalScope('user_id')->where('user_id', Auth::id())->get();
        //debug($getActivityDataWithoutScope);
        return [
            'id' => 'personal',
            'name' => trans('cruds.profile.finance.personal'),
            'sum_activity' => $getActivityDataWithoutScope->sum('amount') ?? 0,
            'sum_payments' => $getPaymentDataWithoutScope->sum('amount') ?? 0,
            'sum_balance' => ($getPaymentDataWithoutScope->sum('amount') ?? 0) + -abs(($getActivityDataWithoutScope->sum('amount') ?? 0)),
        ];
    }

    public function getPaymentsCurrentYear(): \Illuminate\Database\Eloquent\Builder|Income|Builder
    {
        return Income::whereHas('income_category', function ($q) {
            $q->where('deposit', '=', 1);
        })
            ->whereBetween('entry_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

//    public function dashboard()
//    {
////        $assetsOverhaulData = $this->getAssetsOverhaulData();
//        $getActivityDataWithoutScope = $this->getActivitiesCurrentYear()->withoutGlobalScope('user_id')->get();
//        $getActivitySumTotalOfAllMembers = $getActivityDataWithoutScope->sum('minutes');
//        $getActivitySumAsCommand = $getActivityDataWithoutScope->where('user_id', Auth::id())->sum('minutes');
//        $getActivitySumAsCopilot = $getActivityDataWithoutScope->where('copilot_id', Auth::id())->sum('minutes');
//        $getActivitySumAsInstructor = $getActivityDataWithoutScope->where('instructor_id', Auth::id())->sum('minutes');
//        $getActivitySumTotalPersonal = $getActivitySumAsCommand + $getActivitySumAsCopilot + $getActivitySumAsInstructor;
//
//
//        debug("Airtime Total: " . $getActivitySumTotalOfAllMembers);
//        debug("Airtime as PIC: " . $getActivitySumAsCommand);
//        debug("Airtime as Copilot: " . $getActivitySumAsCopilot);
//        debug("Airtime as Instructor: " . $getActivitySumAsInstructor);
//        debug("Airtime Total: " . $getActivitySumTotalPersonal);
//
//
//        return compact('getActivitySumTotalOfAllMembers', 'getActivitySumAsCommand', 'getActivitySumAsCopilot', 'getActivitySumAsInstructor', 'getActivitySumTotalPersonal');
//    }

    public function getActivitiesCurrentYear(): \Illuminate\Database\Eloquent\Builder
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

//    public function dashboard_v1(Request $request)
//    {
//        // Call the function
//        $activity_lines = $this->getActivitiesCurrentYear();
//
//        $activityAmountTotal = $activity_lines->sum('amount');
//        $activityMinutesTotal = $activity_lines->sum('minutes');
//        $activityHoursAndMinutes = sprintf("%02d", intval($activityMinutesTotal / 60)) . 'h : ' . sprintf("%02d", $activityMinutesTotal % 60) . 'm';
//
//        // Call the function
//        $income_lines = $this->getDepositIncomesCurrentYear();
//        $incomeAmountTotal = $income_lines->sum('amount');
//        $granTotal = $incomeAmountTotal + -abs($activityAmountTotal);
//
//        // Call the function
//        $assetsOverhaulData = $this->getAssetsOverhaulData();
//
//        return compact('granTotal', 'incomeAmountTotal', 'activityAmountTotal', 'activityHoursAndMinutes', 'assetsOverhaulData');
//    }

    public function getDepositIncomesCurrentYear(): \Illuminate\Database\Eloquent\Builder|Income|Builder
    {
        return Income::whereHas('income_category', function ($q) {
            $q->where('deposit', '=', 1);
        })
            ->whereBetween('entry_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

//    public function getAssetsOverhaulData(): \Illuminate\Database\Eloquent\Collection|array
//    {
//        $activeAssetsWithPlane = Asset::with('plane')->where('status_id', 1)->whereNotNull('plane_id');
//        $activeAssetsGroupedByPlane = $activeAssetsWithPlane->get()->groupBy('plane.callsign');
//
//        foreach ($activeAssetsGroupedByPlane as $plane => $assets) {
//            foreach ($assets as $asset) {
//                $asset->daysUntilDueDate = Carbon::createFromFormat(config('panel.date_format'), $asset->end_date ?? 0)->longAbsoluteDiffForHumans();
//                $asset->hoursUntilOverhaul = $asset->end_hours - ($asset->start_hours + $asset->current_running_hours);
//
//                $assetActualRunningHours = $asset->start_hours + $asset->current_running_hours;
//
//                if ($assetActualRunningHours > 0) {
//                    $asset->progressBarInPercent = $assetActualRunningHours / $asset->end_hours * 100;
//                } else {
//                    $asset->progressBarInPercent = 0;
//                }
//
//                if ($asset->progressBarInPercent <= 50) {
//                    $asset->progressBarColor = 'info';
//                } elseif ($asset->progressBarInPercent >= 50 && $asset->progressBarInPercent <= 80) {
//                    $asset->progressBarColor = 'warning';
//                } elseif ($asset->progressBarInPercent >= 80) {
//                    $asset->progressBarColor = 'danger';
//                }
//            }
//        }
//
//        return $activeAssetsGroupedByPlane;
//
//    }

    public function getUsersMedicalDue($request): false|array
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

    public function getActivitiesAllTime(): \Illuminate\Database\Eloquent\Collection
    {
        return Activity::all();
    }

    public function getActivityReport($fromDate, $toDate): array
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
                        'name' => $line->user->name,
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
                        'name' => $line->type->name,
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
                        'callsign' => $line->plane->callsign,
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
                        'name' => $line->instructor->name,
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

    public function getActivitiesByFilter($fromDate, $toDate): \Illuminate\Database\Eloquent\Builder
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

    public function getIncomesCurrentYear(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return Income::with('income_category')
            ->whereBetween('entry_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

    public function getExpensesCurrentYear(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return Expense::with('expense_category')
            ->whereBetween('entry_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
    }

    public function getExpenseReport($fromDate, $toDate): array
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
//
//        /* Overdue payment members */
//        $overdueMembers = DB::select("
//        SELECT
//            u.id,
//            u.name,
//            COALESCE(suminc, 0) AS suminc,
//            COALESCE(sumact, 0) AS sumact,
//            COALESCE(suminc, 0) - COALESCE(sumact, 0) AS total
//        FROM
//            users u
//                LEFT JOIN
//            (SELECT
//                user_id, SUM(amount) AS sumact
//            FROM
//                activities a
//            WHERE
//                a.event BETWEEN (:activityfrom) AND (:activityto) AND a.deleted_at is null
//            GROUP BY a.user_id) a ON u.id = a.user_id
//                LEFT JOIN
//            (SELECT
//                user_id, SUM(amount) AS suminc
//            FROM
//                incomes i
//            INNER JOIN income_categories ic ON i.income_category_id = ic.id
//            WHERE
//                i.entry_date BETWEEN (:incomefrom) AND (:incometo)
//                    AND ic.deposit = 1 AND i.deleted_at is null
//            GROUP BY i.user_id) i ON u.id = i.user_id
//        ORDER BY total ASC
//        ", array(
//            'activityfrom' => $fromDate,
//            'activityto' => $toDate,
//            'incomefrom' => $fromDate,
//            'incometo' => $toDate
//        ), true);

        return [
            'expensesSummary' => $expensesSummary,
            'incomesSummary' => $incomesSummary,
            'expensesTotal' => $expensesTotal,
            'incomesTotal' => $incomesTotal,
            'profit' => $profit,
//            'overdueMembers' => $overdueMembers,
            'fromSelectedDate' => $fromDate,
            'toSelectedDate' => $toDate

        ];
    }

    public function getExpensesByFilter($fromDate, $toDate): \Illuminate\Database\Eloquent\Builder
    {
        return Expense::with('expense_category')
            ->whereBetween('entry_date', [$fromDate, $toDate]);
    }

    public function getIncomesByFilter($fromDate, $toDate): \Illuminate\Database\Eloquent\Builder
    {
        return Income::with('income_category')
            ->whereBetween('entry_date', [$fromDate, $toDate]);
    }

    public function getReservationsByType(): array
    {
        $allModes = Mode::whereIn('id', [Reservation::IS_CHARTER, Reservation::IS_SCHOOL])
            ->pluck('name', 'id')
            ->toArray();
        $allTypes = array_values($allModes);
        $series = array_fill(0, count($allTypes), 0);
        $labels = $allTypes;

        $totalEntries = Reservation::whereYear('reservation_start', Carbon::now()->year)->count();

        $results = Reservation::selectRaw('mode_id, COUNT(*) as total')
            ->whereIn('mode_id', [Reservation::IS_CHARTER, Reservation::IS_SCHOOL])
            ->whereYear('reservation_start', Carbon::now()->year)
            ->groupBy('mode_id')
            ->pluck('total', 'mode_id');

        foreach ($results as $modeId => $total) {
            if (isset($allModes[$modeId])) {
                $index = array_search($allModes[$modeId], $allTypes);
                if ($index !== false) {
                    $series[$index] = round(($totalEntries > 0) ? ($total / $totalEntries) * 100 : 0, 0);
                }
            }
        }

        return [
            'series' => $series,
            'labels' => $labels,
        ];
    }

    public function getActivitiesByAircraft(): array
    {
        $activities = Activity::selectRaw('plane_id, DATE_FORMAT(event, "%m") as month, SUM(minutes) as total_minutes')
            ->groupBy('plane_id', 'month')
            ->with('plane')
            ->whereYear('event', Carbon::now()->year)
            ->get();

        $series = [];

        $activitiesByPlane = $activities->groupBy('plane_id');

        $allMonths = collect([
            '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'
        ]);

        foreach ($activitiesByPlane as $planeActivities) {
            $plane = $planeActivities->first()->plane;
            $planeName = $plane ? $plane->callsign : 'Unknown';

            $monthlyData = [];
            foreach ($planeActivities as $activity) {
                $month = $activity->month;
                $monthlyData[$month] = round($activity->total_minutes / 60, 0); // Minuten in Stunden umgewandelt
            }

            $data = [];
            foreach ($allMonths as $month) {
                $data[] = $monthlyData[$month] ?? 0;
            }

            $series[] = [
                'name' => $planeName,
                'data' => $data,
            ];
        }

        return [
            'series' => $series,
            'categories' => $allMonths,
        ];
    }

    public function getActivitiesByUsers(): array
    {
        $topPilots = Activity::join('users', 'activities.user_id', '=', 'users.id')
            ->selectRaw('users.name, ROUND(SUM(activities.minutes) / 60, 2) as hours') // Minuten direkt in Stunden umrechnen und runden
            ->whereYear('activities.event', Carbon::now()->year)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('hours')
            ->limit(10)
            ->get()
            ->toArray();

        $names = array_column($topPilots, 'name');
        $hours = array_column($topPilots, 'hours');

        return [
            'name' => $names,
            'hours' => [['data' => $hours]],
        ];
    }

    public function getActivitiesByType(): array
    {
        $allTypes = ['Charter', 'School'];
        $series = array_fill(0, count($allTypes), 0);
        $labels = $allTypes;

        $totalEntries = Activity::whereYear('event', Carbon::now()->year)->count();

        $results = Activity::selectRaw('IF(instructor_id IS NOT NULL, "School", "Charter") as category, COUNT(*) as total')
            ->whereYear('event', Carbon::now()->year)
            ->groupBy('category')
            ->pluck('total', 'category');

        foreach ($results as $category => $total) {
            $index = array_search($category, $allTypes);
            if ($index !== false) {
                $series[$index] = ($totalEntries > 0) ? ($total / $totalEntries) * 100 : 0;
            }
        }

        return [
            'series' => $series,
            'labels' => $labels,
        ];
    }
}

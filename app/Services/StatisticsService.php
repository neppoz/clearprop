<?php

namespace App\Services;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Models\Income;
use App\Models\Mode;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class StatisticsService
{
    public function getGlobalActivityStatistics(): array
    {
        $getActivityData = $this->getActivitiesPastMonths(6)->get();

        return [
            'id' => 'global',
            'name' => trans('cruds.dashboard.statistics.global'),
            'sum' => $getActivityData->sum('minutes') ?? 0,
            'avg' => $getActivityData->avg('minutes') ?? 0,
            'count' => $getActivityData->count() ?? 0,
        ];
    }

    public function getPersonalActivityStatistics(): array
    {
        $getActivityDataWithoutScope = $this->getActivitiesPastMonths(6)->get();

        return [
            'id' => 'personal',
            'name' => trans('cruds.dashboard.statistics.personal'),
            'sum' => $getActivityDataWithoutScope->sum('minutes') ?? 0,
            'avg' => $getActivityDataWithoutScope->avg('minutes') ?? 0,
            'count' => $getActivityDataWithoutScope->count() ?? 0,
        ];
    }

    public function getActivitiesPastMonths($months): \Illuminate\Database\Eloquent\Builder|Activity|Builder
    {
        $startDate = Carbon::now()->subMonthsNoOverflow($months)->startOfMonth();

        return Activity::where('status', ActivityStatus::Approved)
            ->where('event', '>=', $startDate)
            ->select(['id', 'minutes', 'status']);
    }

    public function getPaymentsAndCostsOverview(?string $startDate = null, ?string $endDate = null): array
    {
        $queryDeposits = Income::ofDefaultDepositCategory();
        $queryActivities = Activity::query();

        if ($startDate && $endDate) {
            $queryDeposits->whereBetween('created_at', [$startDate, $endDate]);
            $queryActivities->whereBetween('created_at', [$startDate, $endDate]);
        }

        $totalDeposits = $queryDeposits->sum('amount');
        $totalActivities = $queryActivities->sum('amount');

        return [
            'sumDeposits' => $totalDeposits,
            'sumActivities' => $totalActivities,
        ];
    }

    public function validateBalanceCalculation(User $user): float
    {
        $totalDeposits = Income::ofDefaultDepositCategory()->sum('amount');

        $totalActivities = Activity::where('user_id', $user->id)->sum('amount');

        return $totalDeposits - abs($totalActivities);
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

    public function getActivitiesByAircraft($months): array
    {
        $startDate = Carbon::now()->subMonthsNoOverflow($months)->startOfMonth();

        $activities = Activity::selectRaw('plane_id, DATE_FORMAT(event, "%m") as month, SUM(minutes) as total_minutes')
            ->where('event', '>=', $startDate)
            ->groupBy('plane_id', 'month')
            ->with('plane')
            ->get();

        $series = [];

        $activitiesByPlane = $activities->groupBy('plane_id');

        $allMonths = collect(range(0, $months - 1))->map(function ($i) {
            return Carbon::now()->subMonthsNoOverflow($i)->format('m');
        })->reverse();

        foreach ($activitiesByPlane as $planeActivities) {
            $plane = $planeActivities->first()->plane;
            $planeName = $plane ? $plane->callsign : 'Unknown';

            $monthlyData = [];
            foreach ($planeActivities as $activity) {
                $month = str_pad($activity->month, 2, '0', STR_PAD_LEFT);
                $monthlyData[$month] = round($activity->total_minutes / 60, 0);
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
            'categories' => $allMonths->values(),
        ];
    }

    public function getActivitiesByUsers($startDate = null, $endDate = null): array
    {
        $query = Activity::join('users', 'activities.user_id', '=', 'users.id')
            ->selectRaw('users.name, ROUND(SUM(activities.minutes) / 60, 2) as hours')
            ->whereYear('activities.event', Carbon::now()->year)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('hours')
            ->limit(10);

        if ($startDate && $endDate) {
            $query->whereBetween('activities.event', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $topPilots = $query->get()->toArray();

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

    public function UserBalance(string $startDate, string $endDate): \Illuminate\Database\Eloquent\Builder
    {
        return User::query()
            ->select('users.id', 'users.name')
            ->leftJoinSub(
                \DB::table('activities')
                    ->select('user_id', \DB::raw('SUM(amount) AS sumact'))
                    ->whereBetween('event', [$startDate, $endDate])
                    ->where('status', ActivityStatus::Approved)
                    ->whereNull('deleted_at')
                    ->groupBy('user_id'),
                'a',
                'users.id',
                '=',
                'a.user_id'
            )
            ->leftJoinSub(
                \DB::table('incomes')
                    ->select('user_id', \DB::raw('SUM(amount) AS suminc'))
                    ->whereBetween('entry_date', [$startDate, $endDate])
                    ->where('income_category_id', 1)
                    ->whereNull('deleted_at')
                    ->groupBy('user_id'),
                'i',
                'users.id',
                '=',
                'i.user_id'
            )
            ->selectRaw('COALESCE(i.suminc, 0) AS suminc, COALESCE(a.sumact, 0) AS sumact, COALESCE(i.suminc, 0) - COALESCE(a.sumact, 0) AS total');

    }

}

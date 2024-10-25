<?php

namespace App\Filament\Widgets\App;

use App\Services\StatisticsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ActivityOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $collectionActivityStatistics = new \Illuminate\Support\Collection();
        if (\Gate::allows('dashboard_global_activity_access')) {
            $getGlobalActivityStatistics = (new StatisticsService())->getGlobalActivityStatistics();
            $collectionActivityStatistics->push($getGlobalActivityStatistics);
        }
//        if (\Gate::allows('dashboard_instructor_activity_access')) {
//            $getInstructorActivityStatistics = (new StatisticsService())->getInstructorActivityStatistics();
//            $collectionActivityStatistics->push($getInstructorActivityStatistics);
//        }
//        if (\Gate::allows('dashboard_personal_activity_access')) {
//            $getPersonalActivityStatistics = (new StatisticsService())->getPersonalActivityStatistics();
//            $collectionActivityStatistics->push($getPersonalActivityStatistics);
//        }

        $totalAirTime = 'inop';
        $loggedMissions = 'inop';
        $avgDurationPerMission = 'inop';

        foreach ($collectionActivityStatistics as $activityStatistics) {
            if (!empty($activityStatistics['sum'])) {
                $totalAirTime = sprintf("%02d", intval($activityStatistics['sum'] / 60)) . 'h : ' . sprintf("%02d", $activityStatistics['sum'] % 60) . 'm';
            }
            if (!empty($activityStatistics['count'])) {
                $loggedMissions = $activityStatistics['count'];
            }
            if (!empty($avgDurationPerMission)) {
                $avgDurationPerMission = sprintf("%02d", intval($activityStatistics['avg'] / 60)) . 'h : ' . sprintf("%02d", intval($activityStatistics['avg']) % 60) . 'm';
            }
        }

        return [
            Stat::make(trans('cruds.dashboard.statistics.totalAirtime'), $totalAirTime),
            Stat::make(trans('cruds.dashboard.statistics.avgdurationpermission'), $avgDurationPerMission),
            Stat::make(trans('cruds.dashboard.statistics.loggedMissions'), $loggedMissions),
        ];
    }
}

<?php

namespace App\Filament\Widgets\App;

use App\Services\StatisticsService;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ActivityOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 1;
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $collectionActivityStatistics = new \Illuminate\Support\Collection();
        if (\Auth::user()->is_admin) {
            $getGlobalActivityStatistics = (new StatisticsService())->getGlobalActivityStatistics();
            $collectionActivityStatistics->push($getGlobalActivityStatistics);
        }

        if (\Auth::user()->is_member) {
            $getPersonalActivityStatistics = (new StatisticsService())->getPersonalActivityStatistics();
            $collectionActivityStatistics->push($getPersonalActivityStatistics);
        }

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
            Stat::make(__('panel.totalAirtime'), $totalAirTime)
                ->description($avgDurationPerMission . ' ' . __('panel.avgDuration'))
                ->color('success'),
            Stat::make(trans('panel.loggedMissions'), $loggedMissions),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }
}

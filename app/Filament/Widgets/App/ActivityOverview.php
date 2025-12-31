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
        $user = \Auth::user();
        $statisticsService = new StatisticsService();
        $personalStats = null;
        $instructorStats = null;

        if ($user->is_admin) {
            $collectionActivityStatistics->push($statisticsService->getGlobalActivityStatistics());
        } elseif ($user->is_instructor) {
            $personalStats = $statisticsService->getPersonalActivityStatistics();
            $instructorStats = $statisticsService->getInstructorActivityStatistics($user);
            $collectionActivityStatistics->push($personalStats);
            $collectionActivityStatistics->push($instructorStats);
        } elseif ($user->is_member) {
            $collectionActivityStatistics->push($statisticsService->getPersonalActivityStatistics());
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
            if (!empty($activityStatistics['avg'])) {
                $avgDurationPerMission = sprintf("%02d", intval($activityStatistics['avg'] / 60)) . 'h : ' . sprintf("%02d", intval($activityStatistics['avg']) % 60) . 'm';
            }
        }

        $totalDescription = $avgDurationPerMission . ' ' . __('panel.avgDuration');
        $missionsDescription = null;

        if ($user->is_instructor && $personalStats && $instructorStats) {
            $personalHours = $this->formatMinutes((int) ($personalStats['sum'] ?? 0));
            $instructorHours = $this->formatMinutes((int) ($instructorStats['sum'] ?? 0));
            $totalMinutes = (int) ($personalStats['sum'] ?? 0) + (int) ($instructorStats['sum'] ?? 0);
            $totalCount = (int) ($personalStats['count'] ?? 0) + (int) ($instructorStats['count'] ?? 0);

            $totalAirTime = $this->formatMinutes($totalMinutes);
            $loggedMissions = $totalCount > 0 ? $totalCount : 'inop';
            $avgDurationPerMission = $totalCount > 0
                ? $this->formatMinutes((int) round($totalMinutes / $totalCount))
                : 'inop';

            $totalDescription = __('activities.stats.personal_hours') . ': ' . $personalHours
                . ' · ' . __('activities.stats.instructor_hours') . ': ' . $instructorHours;
            $missionsDescription = __('activities.stats.personal_hours') . ': ' . ($personalStats['count'] ?? 0)
                . ' · ' . __('activities.stats.instructor_hours') . ': ' . ($instructorStats['count'] ?? 0);
        }

        return [
            Stat::make(__('panel.totalAirtime'), $totalAirTime)
                ->description($totalDescription)
                ->color('success'),
            Stat::make(trans('panel.loggedMissions'), $loggedMissions)
                ->description($missionsDescription),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }

    protected function formatMinutes(int $minutes): string
    {
        return sprintf('%02d', intval($minutes / 60)) . 'h : ' . sprintf('%02d', $minutes % 60) . 'm';
    }
}

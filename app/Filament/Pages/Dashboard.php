<?php

namespace App\Filament\Pages;

use App\Filament\Resources\ActivityResource\Widgets\ActivitiesAircraftChart;
use App\Filament\Widgets\App\ActivityOverview;
use App\Filament\Widgets\App\LatestReservations;
use App\Filament\Widgets\App\UserInfo;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            UserInfo::class,
            ActivitiesAircraftChart::class,
            ActivityOverview::class,
            LatestReservations::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 1; // 2-Spalten-Layout (Standard)
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}

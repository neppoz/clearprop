<?php

namespace App\Filament\Pages\Widgets;

use App\Services\StatisticsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserBalance extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();

        if ($user && $user->is_member) {
            $currentUserBalance = (new StatisticsService())->validateBalanceCalculation($user);

            if ($currentUserBalance >= 0) {
                $color = 'success';
            } else {
                $color = 'warning';
            }

            return [
                Stat::make(trans('panel.depositTotal'), number_format($currentUserBalance, 2, ',', '.') . ' €')
                    ->color($color)
                    ->chart([0, 0])
            ];
        }

        return [];
    }


}

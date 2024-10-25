<?php

namespace App\Filament\Resources\IncomeResource\Widgets;

use App\Services\StatisticsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaymentOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $totalActivityStatisticsCurrentYear = (new StatisticsService())
            ->getActivityStatisticsCurrentYear()->sum('amount') ?? 0;
        $totalPaymentsCurrentYear = (new StatisticsService())
            ->getPaymentsCurrentYear()->sum('amount') ?? 0;
        $totalBalance = $totalPaymentsCurrentYear + -abs($totalActivityStatisticsCurrentYear);

        if ($totalBalance >= 0) {
            $color = 'success';
        } else {
            $color = 'danger';
        }

        return [
            Stat::make('Total balance', number_format($totalBalance, 0, ',', '.'))
                ->color($color)
                ->chart([0, 0]),
            Stat::make('Spending', number_format($totalPaymentsCurrentYear, 0, ',', '.')),
            Stat::make('Activity deposit', number_format($totalActivityStatisticsCurrentYear, 0, ',', '.')),
        ];
    }
}

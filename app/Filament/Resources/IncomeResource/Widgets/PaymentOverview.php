<?php

namespace App\Filament\Resources\IncomeResource\Widgets;

use App\Services\StatisticsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PaymentOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();

        $getBalanceOverview = (new StatisticsService())->getPaymentsAndCostsOverview();

        $sumDeposits = $getBalanceOverview['sumDeposits'] ?? 0;

        $sumActivities = $getBalanceOverview['sumActivities'] ?? 0;

        $total = $sumDeposits - abs($sumActivities);

        if ($total >= 0) {
            $color = 'success';
        } else {
            $color = 'warning';
        }

        $stats = [
            Stat::make(trans('panel.depositTotal'), number_format($total, 2, ',', '.') . ' €')
                ->color($color)
                ->chart([0, 0]),
        ];

        if ($user && $user->is_admin) {
            $stats[] = Stat::make('Deposit', number_format($sumDeposits, 2, ',', '.') . ' €');
            $stats[] = Stat::make('Activity spending', number_format($sumActivities, 2, ',', '.') . ' €');
        }

        return $stats;
    }
}

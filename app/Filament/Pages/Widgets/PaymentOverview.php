<?php

namespace App\Filament\Pages\Widgets;

use App\Services\StatisticsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PaymentOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 1;

    public ?string $startDate = null;
    public ?string $endDate = null;

    protected function getStats(): array
    {
        $user = Auth::user();

        $startDate = $this->startDate ?? now()->startOfYear()->toDateString();
        $endDate = $this->endDate ?? now()->endOfYear()->toDateString();

        $getBalanceOverview = (new StatisticsService())->getPaymentsAndCostsOverview($startDate, $endDate);

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
                ->chart([0, 0])

        ];

        if ($user && $user->is_admin) {
            $stats[] = Stat::make('Deposit', number_format($sumDeposits, 2, ',', '.') . ' €');
            $stats[] = Stat::make('Activity spending', number_format($sumActivities, 2, ',', '.') . ' €');
        }

        return $stats;
    }

    protected function getListeners(): array
    {
        return [
            'filterUpdated' => 'updateFilter',
            'refreshStats' => '$refresh',
        ];
    }


    public function updateFilter(?string $startDate = null, ?string $endDate = null): void
    {
        $this->startDate = $startDate ?? now()->startOfYear()->toDateString();
        $this->endDate = $endDate ?? now()->endOfYear()->toDateString();

        $this->dispatch('refreshStats');
    }

}

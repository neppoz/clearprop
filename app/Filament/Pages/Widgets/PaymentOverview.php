<?php
namespace App\Filament\Pages\Widgets;

use App\Models\Income;
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

    public function mount(): void
    {
        $this->startDate = Income::min('entry_date') ?? '2000-01-01';
        $this->endDate = now()->toDateString();
    }

    protected function getStats(): array
    {
        $user = Auth::user();

        $getBalanceOverview = (new StatisticsService())->getPaymentsAndCostsOverview($this->startDate, $this->endDate);

        $sumDeposits = $getBalanceOverview['sumDeposits'] ?? 0;
        $sumActivities = $getBalanceOverview['sumActivities'] ?? 0;
        $total = $sumDeposits - abs($sumActivities);

        $color = $total >= 0 ? 'success' : 'warning';

        $stats = [
            Stat::make(trans('panel.depositTotal'), number_format($total, 2, ',', '.') . ' €')
                ->color($color)
                ->chart([0, 0]) // Falls du eine Chart-Logik hast, hier ergänzen
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
        $this->startDate = $startDate ?? Income::min('entry_date') ?? '2000-01-01';
        $this->endDate = $endDate ?? now()->toDateString();

        $this->dispatch('refreshStats');
    }
}

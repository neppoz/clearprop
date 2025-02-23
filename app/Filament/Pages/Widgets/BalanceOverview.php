<?php

namespace App\Filament\Pages\Widgets;

use App\Services\StatisticsService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BalanceOverview extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = null;
    protected static ?string $heading = 'Balance by Member';
    public ?string $startDate = null;
    public ?string $endDate = null;
    protected int|string|array $columnSpan = 'full';

    public function mount(): void
    {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => app(StatisticsService::class)->UserBalance($this->startDate, $this->endDate))
            ->defaultSort('total', 'asc')
            ->paginationPageOptions([5, 10, 15])
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('suminc')
                    ->label('Payments')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.') . ' €'),
                Tables\Columns\TextColumn::make('sumact')
                    ->label('Activity spending')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.') . ' €'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Balance')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.') . ' €'),
            ]);
    }

    public function updateFilter(string $startDate, string $endDate): void
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->resetTable();
    }

    protected function getListeners(): array
    {
        return [
            'filterUpdated' => 'updateFilter',
        ];
    }
}

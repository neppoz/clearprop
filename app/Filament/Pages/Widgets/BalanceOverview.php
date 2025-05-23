<?php
namespace App\Filament\Pages\Widgets;

use App\Models\Income;
use App\Services\StatisticsService;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

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
        $this->startDate = Income::min('entry_date') ?? '2001-01-01';

        $this->endDate = now()->toDateString();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => app(StatisticsService::class)->UserBalance($this->startDate, $this->endDate))
            ->paginationPageOptions([5, 10, 15, 50])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('suminc')
                    ->label('Payments')
                    ->numeric()
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.') . ' €'),

                Tables\Columns\TextColumn::make('sumact')
                    ->label('Activity spending')
                    ->numeric()
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.') . ' €'),

                Tables\Columns\TextColumn::make('total')
                    ->label('Balance')
                    ->numeric()
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.') . ' €'),
            ])
            ->filters([
                Filter::make('Negative Balance')
                    ->query(fn(Builder $query): Builder => $query->whereRaw('COALESCE(i.suminc, 0) - COALESCE(a.sumact, 0) < 0')
                    ),
            ]);
    }

    public function updateFilter(?string $startDate = null, ?string $endDate = null): void
    {
        $this->startDate = $startDate ?? Income::min('entry_date') ?? '2001-01-01';
        $this->endDate = $endDate ?? now()->toDateString();

        $this->dispatch('$refresh');
    }

    protected function getListeners(): array
    {
        return [
            'filterUpdated' => 'updateFilter',
        ];
    }
}

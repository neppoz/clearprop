<?php

namespace App\Filament\Resources\IncomeResource\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class BalanceOverview extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = null;
    protected static ?string $heading = 'Users balance';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->defaultSort('total', 'asc')
            ->paginationPageOptions(['5', '10', '15'])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('suminc')
                    ->label('Payments')
                    ->suffix(' €')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sumact')
                    ->label('Activity spending')
                    ->suffix(' €')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Balance')
                    ->suffix(' €')
                    ->sortable(),
            ]);

    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|null
    {
        $activityFrom = '2024-01-01'; // Platzhalter: dynamische Filterung, wenn nötig
        $activityTo = '2024-12-31';
        $incomeFrom = '2024-01-01';
        $incomeTo = '2024-12-31';

        return User::query()
            ->select('users.id', 'users.name')
            ->leftJoinSub(
                DB::table('activities')
                    ->select('user_id', DB::raw('SUM(amount) AS sumact'))
                    ->whereBetween('event', [$activityFrom, $activityTo])
                    ->whereNull('deleted_at')
                    ->groupBy('user_id'),
                'a',
                'users.id',
                '=',
                'a.user_id'
            )
            ->leftJoinSub(
                DB::table('incomes')
                    ->join('income_categories', 'incomes.income_category_id', '=', 'income_categories.id')
                    ->select('user_id', DB::raw('SUM(incomes.amount) AS suminc'))
                    ->whereBetween('entry_date', [$incomeFrom, $incomeTo])
                    ->where('income_categories.deposit', 1)
                    ->whereNull('incomes.deleted_at')
                    ->groupBy('user_id'),
                'i',
                'users.id',
                '=',
                'i.user_id'
            )
            ->selectRaw('COALESCE(suminc, 0) AS suminc, COALESCE(sumact, 0) AS sumact, COALESCE(suminc, 0) - COALESCE(sumact, 0) AS total');
    }

}

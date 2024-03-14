<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BookingResource;
use App\Models\Reservation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LatestReservations extends BaseWidget
{
    protected static ?int $sort = 0;
    protected int|string|array $columnSpan = 'full';


    public function table(Table $table): Table
    {
        return $table
            ->query(BookingResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('reservation_start', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('plane.callsign')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservation_start')
                    ->searchable()
                    ->sortable()
                    ->date(),
//                Tables\Columns\TextColumn::make('reservation_start')
//                    ->searchable()
//                    ->sortable(),
                Tables\Columns\TextColumn::make('reservation_stop')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mode.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Charter' => 'primary',
                        'School' => 'gray',
                        'Maintenance' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->wrap(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn(Reservation $record): string => BookingResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}

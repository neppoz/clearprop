<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use Filament\Panel;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;

class LatestReservations extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(ReservationResource::getEloquentQuery())
            ->paginationPageOptions(['5', '10', '15'])
            ->defaultSort('reservation_start', 'desc')
            ->headerActions([
                Tables\Actions\Action::make('create')
                    ->label('New reservation')
                    ->icon('heroicon-m-sparkles')
                    ->outlined()
                    ->url(ReservationResource::getUrl('create')),
            ])
            ->columns([
                Split::make([
                    Stack::make([
                        Tables\Columns\TextColumn::make('plane.callsign')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('mode.name')
                            ->label('')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Charter' => 'primary',
                                'School' => 'gray',
                                'Maintenance' => 'danger',
                            }),
                    ]),
                    Stack::make([
                        Tables\Columns\TextColumn::make('bookingUsers.name')
                            ->label('Pilot')
                            ->sortable()
                            ->searchable(),
                        Tables\Columns\TextColumn::make('bookingInstructors.name')
                            ->label('Instructor')
                            ->sortable()
                            ->searchable(),
                    ]),
                    Stack::make([
                        Tables\Columns\TextColumn::make('reservation_start')
                            ->label('From')
                            ->searchable()
                            ->dateTime('D d/m/y'),
                        Tables\Columns\TextColumn::make('reservation_start')
                            ->weight('medium')
                            ->searchable()
                            ->dateTime('H:i'),
                    ]),
                    Stack::make([
                        Tables\Columns\TextColumn::make('reservation_stop')
                            ->label('To')
                            ->searchable()
                            ->dateTime('D d/m/y'),
                        Tables\Columns\TextColumn::make('reservation_stop')
                            ->weight('medium')
                            ->searchable()
                            ->dateTime('H:i'),

                    ]),
                    Stack::make([
                        Tables\Columns\TextColumn::make('created_by.name')
                            ->weight('medium')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('description')
                            ->color('gray')
                            ->searchable(),
                    ])
                ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn(Reservation $record): string => ReservationResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}

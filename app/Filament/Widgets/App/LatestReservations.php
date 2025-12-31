<?php

namespace App\Filament\Widgets\App;

use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestReservations extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getReservationsQuery())
            ->paginationPageOptions(['5', '10', '15'])
            ->defaultSort('reservation_start', 'desc')
            ->headerActions([
                Tables\Actions\Action::make('create')
                    ->label(__('panel.new_reservation_action'))
                    ->icon('heroicon-m-sparkles')
                    ->outlined()
                    ->url(ReservationResource::getUrl()),
            ])
            ->columns([
                Split::make([
                    Stack::make([
                        Tables\Columns\TextColumn::make('plane.callsign')
                            ->label(__('reservations.aircraft'))
                            ->searchable()
                            ->sortable()
                            ->badge()
                            ->color(function (?string $state, $record): string {
                                return match ($record->mode->name ?? null) {
                                    'Charter' => 'primary',
                                    'School' => 'gray',
                                    'Maintenance' => 'danger',
                                    default => 'secondary',
                                };
                            })
                            ->formatStateUsing(fn(?string $state, $record): string => $state),
                    ]),
                    Stack::make([
                        Tables\Columns\TextColumn::make('bookingUsers.name')
                            ->label(__('reservations.pic'))
                            ->sortable()
                            ->searchable(),
                        Tables\Columns\TextColumn::make('bookingInstructors.name')
                            ->label(__('reservations.instructor'))
                            ->sortable()
                            ->searchable(),
                        Tables\Columns\TextColumn::make('description')
                            ->label(__('reservations.remarks'))
                            ->color('gray'),
                    ]),
                    Stack::make([
                        Tables\Columns\TextColumn::make('reservation_start')
                            ->label(__('reservations.from'))
                            ->searchable()
                            ->dateTime('D d/m/y'),
                        Tables\Columns\TextColumn::make('reservation_start')
                            ->weight('medium')
                            ->searchable()
                            ->dateTime('H:i'),
                    ]),
                    Stack::make([
                        Tables\Columns\TextColumn::make('reservation_stop')
                            ->label(__('reservations.to'))
                            ->searchable()
                            ->dateTime('D d/m/y'),
                        Tables\Columns\TextColumn::make('reservation_stop')
                            ->weight('medium')
                            ->searchable()
                            ->dateTime('H:i'),

                    ]),
                ])
            ]);
    }

    private function getReservationsQuery()
    {
        $startDate = Carbon::now()->subMonthsNoOverflow(6)->startOfMonth();

        return Reservation::with('mode')->where('reservation_start', '>=', $startDate);
    }

    public function getTableHeading(): ?string
    {
        return __('panel.latest_reservations');
    }

}

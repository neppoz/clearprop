<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\Widgets\BookingsCalendar;
use App\Models\Plane;
use App\Models\Reservation;
use App\Models\User;
use App\Services\BookingCheckService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static bool $shouldCollapseNavigationGroup = true;
    public static function form(Form $form): Form
    {
        /* This is not standard. Calling the form in the function, so we can use it in the Widget as well. */
        return $form
            ->schema((new ReservationResource)->getReusableForm());
    }
    public function getReusableForm(): array
    {
        return [
            Fieldset::make('Aircraft')
                ->schema([
                    Select::make('plane_id')
                        ->label('')
                        ->native(false)
                        ->relationship('plane', 'callsign', fn($query) => $query->where('active', true))
                        ->options(function ($record) {
                            $activePlanes = Plane::where('active', true)->pluck('callsign', 'id');

                            // Stelle sicher, dass der aktuelle Wert verfügbar bleibt
                            if ($record && $record->plane_id) {
                                $currentPlane = Plane::find($record->plane_id);
                                if ($currentPlane) {
                                    $activePlanes[$currentPlane->id] = $currentPlane->callsign;
                                }
                            }

                            return $activePlanes;
                        })
                        ->required(),
                ])
                ->columns(1),
            Fieldset::make('Date & Time')
                ->schema([
                    DatePicker::make('reservation_start_date')
                        ->label('Date from')
                        ->firstDayOfWeek(1)
                        ->minDate(now())
                        ->reactive()
                        ->native(false)
                        ->displayFormat(config('panel.date_format'))
                        ->required(),
                    TimePicker::make('reservation_start_time')
                        ->label('Start time')
                        ->seconds(false)
                        ->required(),
                    DatePicker::make('reservation_stop_date')
                        ->label('Date to')
                        ->firstDayOfWeek(1)
                        ->native(false)
                        ->displayFormat(config('panel.date_format'))
                        ->afterStateUpdated(fn(Set $set, Get $get, $state) => $get('reservation_start_date') && $state < $get('reservation_start_date')
                            ? $set('reservation_stop_date', null)
                            : null
                        )
                        ->minDate(fn(Get $get) => $get('reservation_start_date'))
                        ->required(),
                    TimePicker::make('reservation_stop_time')
                        ->label('End time')
                        ->seconds(false)
                        ->required(),
                ])
                ->columns(4),
            Section::make('Crew')
                ->description('')
                ->schema([
                    Select::make('user_id')
                        ->label('Pilot')
                        ->searchable()
                        ->preload()
                        ->options(User::all()->pluck('name', 'id'))
                        ->default(fn() => Auth::user()->is_member ? Auth::id() : null)
                        ->disabled(fn(): bool => Auth::user()->is_member)
                        ->saveRelationshipsWhenDisabled(true)
                        ->relationship(name: 'bookingUsers', titleAttribute: 'name')
                        ->required(fn(Get $get): bool => $get('mode_id') != Reservation::IS_MAINTENANCE),
                    Select::make('instructor_id')
                        ->label('Instructor')
                        ->searchable()
                        ->preload()
                        ->options(User::instructors()->pluck('name', 'id'))
                        ->disabled(fn(): bool => Auth::user()->is_member)
                        ->relationship(name: 'bookingInstructors', titleAttribute: 'name')
                        ->required(fn(Get $get): bool => $get('mode_id') == Reservation::IS_SCHOOL),
                    Radio::make('mode_id')
                        ->options([
                            Reservation::IS_CHARTER => 'Charter',
                            Reservation::IS_SCHOOL => 'School',
                            Reservation::IS_MAINTENANCE => 'Maintenance'
                        ])
                        ->default(Reservation::IS_CHARTER)
                        ->disableOptionWhen(fn(string $value): bool => Auth::user()->is_member)
                        ->inline()
                        ->label('Select type')
                        ->reactive()
                        ->required(),
                ])
                ->compact()
                ->collapsed(fn() => Auth::user()->is_member)
                ->columns(2),
            Section::make('Remarks')
                ->description('Leave your message here.')
                ->schema([
                    Textarea::make('description')
                        ->label('')
                        ->rows(3)
                ])
                ->compact()
                ->columns(1),
        ];
    }
    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions(['10', '25', '50'])
            ->defaultSort('reservation_start', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('plane.callsign')
                    ->label('Aircraft')
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
                Tables\Columns\TextColumn::make('bookingUsers.name')
                    ->label('Pilot')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bookingInstructors.name')
                    ->label('Instructor')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('reservation_start')
                    ->label('From')
                    ->searchable()
                    ->sortable()
                    ->dateTime('D d/m - H:i'),
                Tables\Columns\TextColumn::make('reservation_stop')
                    ->label('To')
                    ->searchable()
                    ->sortable()
                    ->dateTime('D d/m - H:i'),
                Tables\Columns\TextColumn::make('created_by.name')
                    ->label('Created by')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('reservation_start')
                    ->label('Date')
                    ->date('D d/m/Y')
                    ->collapsible(),
            ]);
    }

    public static function hasOverlappingReservation($data): bool
    {
        // Prüfe, ob der Benutzer die Admin-Rolle hat
        if (Auth::user()->is_admin) {
            // Überspringe die Überschneidungsprüfung für Admin-Benutzer
            return false;
        }

        // Definiere die Start- und Endzeiten aus den Form-Daten
        $startTime = $data['reservation_start_date'] . ' ' . $data['reservation_start_time'];
        $endTime = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time'];
        $planeId = $data['plane_id'];

        return Plane::where('id', $planeId)
            ->whereHas('planeBookings', function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    // Abfrage für echte Überschneidungen mit vollständigem Datum und Zeit
                    $query->where('reservation_start', '<', $endTime)
                        ->where('reservation_stop', '>', $startTime);
                });
            })->exists();
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
            'view' => Pages\ViewReservation::route('/{record}'),
        ];
    }
    public static function getWidgets(): array
    {
        return [
            BookingsCalendar::class,
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

}

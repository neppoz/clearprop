<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\Widgets\BookingsCalendar;
use App\Models\Activity;
use App\Models\Plane;
use App\Models\Reservation;
use App\Models\User;
use App\Services\ReservationValidator;
use App\Services\StatisticsService;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Gate;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function canViewAny(): bool
    {
        return Gate::allows('viewReservations');
    }

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
                        ->preload()
                        ->native(true)
                        ->relationship('plane', 'callsign', fn($query) => $query->where('active', true))
                        ->options(function ($record) {
                            $activePlanes = Plane::where('active', true)->pluck('callsign', 'id');

                            // Make sure that the value persists
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
                        ->minDate(Carbon::now()->setTimezone(config('app.timezone'))->format('Y-m-d'))
                        ->native(true)
                        ->live(onBlur: true)
                        ->displayFormat(config('panel.date_format'))
                        ->required(),
                    TimePicker::make('reservation_start_time')
                        ->label('Start time')
                        ->seconds(false)
                        ->native(true)
                        ->reactive()
                        ->required(),
                    DatePicker::make('reservation_stop_date')
                        ->label('Date to')
                        ->firstDayOfWeek(1)
                        ->native(true)
                        ->live(onBlur: true)
                        ->displayFormat(config('panel.date_format'))
                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
                            $startDate = $get('reservation_start_date');
                            if ($startDate && $state < $startDate) {
                                $set('reservation_stop_date', null); // Reset only when smaller
                            }
                        })
                        ->minDate(fn(Get $get) => $get('reservation_start_date'))
                        ->required(),
                    TimePicker::make('reservation_stop_time')
                        ->label('End time')
                        ->seconds(false)
                        ->native(true)
                        ->reactive()
                        ->required(),
                ])
                ->columns(4),
            Section::make('Crew')
                ->description('')
                ->schema([
                    Select::make('user_id')
                        ->label('PIC')
                        ->searchable()
                        ->preload()
                        ->native(true)
                        ->default(fn() => Auth::user()->is_member ? Auth::id() : null)
                        ->disabled(fn(): bool => Auth::user()->is_member)
                        ->saveRelationshipsWhenDisabled(true)
                        ->relationship(name: 'bookingUsers', titleAttribute: 'name')
                        ->required(fn(Get $get): bool => $get('mode_id') != Reservation::IS_MAINTENANCE),

                    Select::make('instructor_id')
                        ->label('Instructor')
                        ->searchable()
                        ->preload()
                        ->native(true)
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
            ->paginationPageOptions(['5', '10', '25'])
            ->defaultSort('reservation_start', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('plane.callsign')
                    ->label('Aircraft')
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
                Tables\Columns\TextColumn::make('bookingUsers.name')
                    ->label('PIC')
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
                Tables\Columns\TextColumn::make('description')
                    ->label('Remarks')
                    ->color('gray')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visible(fn() => auth()->user()->is_admin),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->visible(fn() => auth()->user()->is_admin),
                Tables\Filters\Filter::make('last_6_months')
                    ->label(__('panel.last_6_months'))
                    ->query(fn(Builder $query) => $query->where('reservation_start', '>=', Carbon::now()->subMonthsNoOverflow(6)->startOfMonth()))
                    ->default(true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([

            ])
            ->groups([
                Tables\Grouping\Group::make('reservation_start')
                    ->label('Date')
                    ->date('D d/m/Y')
                    ->collapsible(),
            ]);
    }

    public function validateReservation(array $data): bool
    {
        $user = auth()->user();
        $settings = app(GeneralSettings::class);

        $selectedAircraft = Plane::where('id', $data['plane_id'])->first();
        $reservationStartDate = Carbon::parse($data['reservation_start_date'])->toDateString();
        $reservationStartTime = Carbon::parse($reservationStartDate . ' ' . $data['reservation_start_time']);
        $reservationStopDate = Carbon::parse($data['reservation_stop_date'])->toDateString();
        $reservationStopTime = Carbon::parse($reservationStopDate . ' ' . $data['reservation_stop_time']);
        $bookingId = $data['id'] ?? null;

        // Checks for members only
        if ($user->is_member) {

            if ($settings->check_activities) {

                $airWorthiness = (new ReservationValidator())->validateAirworthiness($reservationStartDate, $selectedAircraft, $user);

                if (!$airWorthiness) {
                    Notification::make()
                        ->title("Airworthiness for {$selectedAircraft->callsign} expired")
                        ->body('Please select a different aircraft or contact administrator.')
                        ->danger()
                        ->send();

                    return false;
                }

            }

            // Check if reservation is overlapping
            $overlapExists = (new ReservationValidator())->validateOverlappingReservation($selectedAircraft, $reservationStartTime, $reservationStopTime, $bookingId);

            if ($overlapExists) {
                Notification::make()
                    ->title("Overlapping reservation for {$selectedAircraft->callsign}")
                    ->body('Please select a different period or contact administrator.')
                    ->danger()
                    ->send();

                return false;
            }

        }

        return true;
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
        $query = parent::getEloquentQuery();

        if (auth()->user()->is_admin) {
            return $query->withoutGlobalScopes();
        }

        return $query;
    }

}

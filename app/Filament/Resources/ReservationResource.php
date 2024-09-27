<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static bool $shouldCollapseNavigationGroup = true;
    public static function form(Form $form): Form
    {
        /* This is not standard. Calling the form in the function, so we can use it in the Widget as well. */
        return $form->schema((new ReservationResource)->getReusableForm());
    }

    public function getReusableForm(): array
    {
        return [
            Section::make()
                ->schema([
                    Radio::make('mode_id')
                        ->options([
                            Reservation::IS_CHARTER => 'Charter',
                            Reservation::IS_SCHOOL => 'School',
                            Reservation::IS_MAINTENANCE => 'Maintenance'
                        ])
                        ->label('Select type')
                        ->inline()
                        ->live()
                        ->required(),
                    Select::make('plane_id')
                        ->label('Aircraft')
                        ->relationship('plane', 'callsign')
                        ->required(),
                ])
                ->columns(2),
            Section::make()
                ->schema([
                    DatePicker::make('reservation_start_date')
                        ->label('From')
                        ->firstDayOfWeek(1)
                        ->displayFormat(config('panel.date_format'))
                        ->required(),
                    TimePicker::make('reservation_start_time')
                        ->seconds(false)
                        ->required(),
                    DatePicker::make('reservation_stop_date')
                        ->label('To')
                        ->firstDayOfWeek(1)
                        ->displayFormat('d/m/Y')
                        ->required(),
                    TimePicker::make('reservation_stop_time')
                        ->seconds(false)
                        ->required(),
                ])
                ->columns(2),
            Section::make()
                ->schema([
                    Select::make('bookingUsers')
                        ->searchable()
                        ->label('Pilot')
                        ->options(User::all()->pluck('name', 'id'))
//                            ->searchable()
//                            ->afterStateUpdated(fn(Get $get) => self::getUserRatings($get('user_id')))
//                            ->live(onBlur: true)
                        // ToDo rating notification for admin
                        ->relationship(name: 'bookingUsers', titleAttribute: 'name')
                        ->required(fn(Get $get): bool => $get('type') != Reservation::IS_MAINTENANCE),
                    Select::make('bookingInstructors')
                        ->searchable()
                        ->label('Instructor')
                        ->options(User::instructors()->pluck('name', 'id'))
//                            ->live(onBlur: true)
                        ->relationship(name: 'bookingInstructors', titleAttribute: 'name')
                        ->required(fn(Get $get): bool => $get('type') == Reservation::IS_SCHOOL),
                ])
                ->columns(2),
            Section::make()
                ->schema([
                    ToggleButtons::make('status')
                        ->label('Reservation confirmed?')
                        ->boolean()
                        ->colors([
                            '0' => 'info',
                            '1' => 'success',
                        ])
                        ->inline()
                        ->required(),
                    Textarea::make('description')
                        ->label('Notes')
                        ->rows(5)
                ])
                ->columns(2),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions(['10', '25', '50'])
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('reservation_start')
                    ->label('Date')
                    ->date('D d/m/Y')
                    ->collapsible(),
            ]);
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
        ];
    }

    /** @return Builder<Reservation> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
    }
}

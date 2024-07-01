<?php

namespace App\Filament\Resources;

use App\Enums\ActivityStatus;
use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use App\Models\Plane;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Throwable;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('event')
                            ->required(),
                        Forms\Components\Select::make('plane_id')
                            ->label('Aircraft')
                            ->live()
                            ->relationship('plane', 'callsign')
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource)->calculateMinutesAndCosts($get, $set))
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->label('Pilot')
                            ->live()
                            ->relationship('user', 'name')
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource)->calculateMinutesAndCosts($get, $set))
                            ->required(),
                        Forms\Components\Select::make('instructor_id')
//                            ->disabled(fn(Get $get): bool => $get('split_cost'))
                            ->label('Instructor')
                            ->live()
                            ->relationship('instructor', 'name')
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource)->calculateMinutesAndCosts($get, $set)),
                    ])
                    ->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Toggle::make('engine_warmup')
                            ->inline(false)
                            ->default(false)
                            ->live(),
                        Forms\Components\TextInput::make('warmup_start')
                            ->numeric()
                            ->inputMode('decimal')
                            ->live()
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource)->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => $get('engine_warmup'))
                            ->disabled(fn(Get $get): bool => !$get('engine_warmup')),
                        Forms\Components\TextInput::make('counter_start')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->live()
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource)->calculateMinutesAndCosts($get, $set)),
                        Forms\Components\TextInput::make('counter_stop')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->live()
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource)->calculateMinutesAndCosts($get, $set)),
                        Forms\Components\ToggleButtons::make('status')
                            ->inline()
                            ->options(ActivityStatus::class)
                            ->required()
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('warmup_minutes')
                            ->label('Warmup min.')
                            ->numeric()
                            ->inputMode('integer')
                            ->disabled(fn(Get $get): bool => !$get('engine_warmup'))
                            ->readonly(),
                        Forms\Components\TextInput::make('minutes')
                            ->label('Minutes')
                            ->numeric()
                            ->inputMode('integer')
                            ->readonly(),
                        Forms\Components\TextInput::make('base_price_per_minute')
                            ->label('Base price')
                            ->numeric()
                            ->readonly(),
                        Forms\Components\TextInput::make('instructor_price_per_minute')
                            ->label('Instructor price')
                            ->numeric()
                            ->readonly(),
                        Forms\Components\TextInput::make('discount')
                            ->label('Discount'),
                        Forms\Components\TextInput::make('amount')
                            ->label('Total price')
                            ->numeric()
                            ->inputMode('integer')
                            ->readonly(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 1]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('departure')
                            ->maxLength(255),
                        Forms\Components\TimePicker::make('event_start')
                            ->label('Engine On')
                            ->seconds(false),
                        Forms\Components\TextInput::make('arrival')
                            ->maxLength(255),
                        Forms\Components\TimePicker::make('event_stop')
                            ->label('Engine Off')
                            ->seconds(false),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Notes')
                            ->autosize()
                            ->rows(5),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    protected function calculateMinutesAndCosts(Get $get, Set $set)
    {
        $selectedWarmupCounter = $get('warmup_start') ?? '';
        $selectedCounterStart = $get('counter_start') ?? '';
        $selectedCounterStop = $get('counter_stop') ?? '';
        $selectedPlaneId = $get('plane_id') ?? '';
        $selectedUserId = $get('user_id') ?? '';
        $plane = Plane::find($selectedPlaneId) ?? '';
        $user = User::find($selectedUserId) ?? '';

        /** Calculate minutes without warmup */
        if (!empty($selectedCounterStart && $selectedCounterStop && $selectedPlaneId && $selectedUserId) && empty($selectedWarmupCounter)) {
            $set('warmup_minutes', 0);
            /** industrial minutes calculation */
            if ($plane->counter_type === '100') {
                $calculateCounterDiff = $selectedCounterStop - $selectedCounterStart;
                $minutes = round($calculateCounterDiff * 100 / 5 * 3, 2);
                $set('minutes', $minutes);

                if ($user->planes()->where('plane_id', $plane->id)->exists()) {
                    $base_price_per_minute = $user->planes()->findOrFail($plane->id)->pivot->base_price_per_minute;
                    $set('base_price_per_minute', $base_price_per_minute);
                    $amount = $base_price_per_minute * $minutes;
                    $set('amount', $amount);
                }

            }
            /** Rolling hours and minutes with a decimal */
            if ($plane->counter_type === '060') {
                $calculateCounterDiff = (intval($selectedCounterStop * 60)) + ($selectedCounterStop * 100 % 100) - (intval($selectedCounterStart * 60)) + ($selectedCounterStart * 100 % 100);
                $minutes = round($calculateCounterDiff, 2);
                $set('minutes', $minutes);

                if ($user->planes()->where('plane_id', $plane->id)->exists()) {
                    $base_price_per_minute = $user->planes()->findOrFail($plane->id)->pivot->base_price_per_minute;
                    $amount = $base_price_per_minute * $minutes;
                    $set('amount', $amount);
                }
            }
        }

        /** Calculate minutes with warmup */
        if (!empty($selectedCounterStart && $selectedCounterStop && $selectedPlaneId && $selectedUserId && $selectedWarmupCounter)) {
            /** industrial minutes calculation */
            if ($plane->counter_type === '100') {
                $calculateCounterWarmupDiff = $selectedCounterStart - $selectedWarmupCounter;
                $warmup_minutes = round($calculateCounterWarmupDiff * 100 / 5 * 3, 2);
                $set('warmup_minutes', $warmup_minutes);
                $calculateCounterDiff = $selectedCounterStop - $selectedCounterStart;
                $minutes = round($calculateCounterDiff * 100 / 5 * 3, 2);
                $set('minutes', $minutes);

                if ($user->planes()->where('plane_id', $plane->id)->exists()) {
                    $base_price_per_minute = $user->planes()->findOrFail($plane->id)->pivot->base_price_per_minute;
                    $set('base_price_per_minute', $base_price_per_minute);
                    if ($plane->warmup_type == 0) {
                        $amount = round($base_price_per_minute * $minutes);
                        $set('amount', $amount);
                    }

                    if ($plane->warmup_type == 1) {
                        $amount = round($base_price_per_minute * ($minutes + $warmup_minutes));
                        $set('amount', $amount);
                    }


                }
            }
            /** Rolling hours and minutes with a decimal */
            if ($plane->counter_type === '060') {
                $calculateCounterWarmupDiff = (intval($selectedCounterStart * 60)) + ($selectedCounterStart * 100 % 100) - (intval($selectedWarmupCounter * 60)) + ($selectedWarmupCounter * 100 % 100);
                $warmup_minutes = round($calculateCounterWarmupDiff, 2);
                $set('warmup_minutes', $warmup_minutes);
                $calculateCounterDiff = (intval($selectedCounterStop * 60)) + ($selectedCounterStop * 100 % 100) - (intval($selectedCounterStart * 60)) + ($selectedCounterStart * 100 % 100);
                $minutes = round($calculateCounterDiff, 2);
                $set('minutes', $minutes);

                if ($user->planes()->where('plane_id', $plane->id)->exists()) {
                    $base_price_per_minute = $user->planes()->findOrFail($plane->id)->pivot->base_price_per_minute;
                    $set('base_price_per_minute', $base_price_per_minute);
                    if ($plane->warmup_type == 0) {
                        $amount = round($base_price_per_minute * $minutes);
                        $set('amount', $amount);
                    }

                    if ($plane->warmup_type == 1) {
                        $amount = round($base_price_per_minute * ($minutes + $warmup_minutes));
                        $set('amount', $amount);
                    }

                }
            }
        }

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event')
                    ->date('D d/m/Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('plane.callsign')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('departure')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('event_start')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('arrival')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('event_stop')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('split_cost')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('copilot.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('full_counter')
                    ->label('Counter')
                    ->numeric(2)
                    ->searchable([
                        'counter_start', 'counter_stop'])
                    ->sortable([
                        'counter_start', 'counter_stop'])
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('warmup_minutes')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('minutes')
                    ->numeric(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
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
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_by.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('event', 'desc')
            ->persistSortInSession()
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }


}

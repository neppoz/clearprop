<?php

namespace App\Filament\Resources;

use App\Enums\ActivityStatus;
use App\Filament\Resources\ActivityResource\CustomSummarizerMinutes;
use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\Widgets\ActivitiesAircraftChart;
use App\Filament\Resources\ActivityResource\Widgets\ActivitiesTypeChart;
use App\Filament\Resources\ActivityResource\Widgets\ActivitiesUserChart;
use App\Models\Activity;
use App\Models\Plane;
use App\Models\PlaneUser;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static bool $shouldCollapseNavigationGroup = true;

    public static function canViewAny(): bool
    {
        return Gate::allows('viewActivities');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('event')
                            ->label('Date')
                            ->native(true)
                            ->reactive()
                            ->required(),

                        Forms\Components\Select::make('plane_id')
                            ->label('Aircraft')
                            ->preload()
                            ->native(false)
                            ->relationship('plane', 'callsign')
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(),

                        Forms\Components\Select::make('user_id')
                            ->label('Pilot')
                            ->preload()
                            ->native(false)
                            ->searchable()
                            ->options(User::all()->pluck('name', 'id'))
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(),

                        Forms\Components\Select::make('instructor_id')
                            ->label('Instructor')
                            ->preload()
                            ->native(false)
                            ->searchable()
                            ->options(User::instructors()->pluck('name', 'id'))
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set)),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Trip Info')
                    ->icon('heroicon-m-globe-alt')
                    ->iconColor('info')
                    ->schema([
                        Forms\Components\TextInput::make('departure')
                            ->label('Departure')
                            ->maxLength(255),

                        Forms\Components\TimePicker::make('event_start')
                            ->label('Engine On')
                            ->seconds(false)
                            ->live(onBlur: true)
                            ->native(true)
                            ->reactive()
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredEventTime($get)),

                        Forms\Components\TextInput::make('arrival')
                            ->label('Arrival')
                            ->maxLength(255),

                        Forms\Components\TimePicker::make('event_stop')
                            ->label('Engine Off')
                            ->seconds(false)
                            ->native(true)
                            ->reactive()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredEventTime($get)),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->compact(),
                Forms\Components\Section::make('Engine data')
                    ->icon('heroicon-m-cog')
                    ->iconColor('info')
                    ->schema([
                        Forms\Components\Toggle::make('engine_warmup')
                            ->inline(false)
                            ->default(false)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->live(onBlur: true),

                        Forms\Components\TextInput::make('warmup_start')
                            ->numeric(2, ',', '.')
                            ->inputMode('decimal')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => $get('engine_warmup'))
                            ->disabled(fn(Get $get): bool => !$get('engine_warmup')),

                        Forms\Components\TextInput::make('warmup_minutes')
                            ->label('Warmup min.')
                            ->suffixIcon('heroicon-m-clock')
                            ->numeric(2, ',', '.')
                            ->inputMode('integer')
                            ->disabled(fn(Get $get): bool => !$get('engine_warmup'))
                            ->readonly(),

                        Forms\Components\TextInput::make('counter_start')
                            ->numeric(2, ',', '.')
                            ->inputMode('decimal')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),

                        Forms\Components\TextInput::make('counter_stop')
                            ->numeric(2, ',', '.')
                            ->inputMode('decimal')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->compact(),
                Forms\Components\Section::make('Calculations')
                    ->icon('heroicon-m-variable')
                    ->iconColor('info')
                    ->schema([
                        Forms\Components\TextInput::make('minutes')
                            ->label('Minutes')
                            ->suffixIcon('heroicon-m-clock')
                            ->numeric(2, ',', '.')
                            ->inputMode('integer')
                            ->readonly(),

                        Forms\Components\TextInput::make('base_price_per_minute')
                            ->label('Base Price per Minute')
                            ->numeric(2, ',', '.')
                            ->readonly()
                            ->default(fn(Get $get) => Plane::find($get('plane_id'))->default_price_per_minute ?? 0),

                        Forms\Components\TextInput::make('instructor_price_per_minute')
                            ->label('Instructor Price per Minute')
                            ->numeric(2, ',', '.')
                            ->readonly()
                            ->default(fn(Get $get) => Plane::find($get('plane_id'))->instructor_price_per_minute ?? 0),

                        Forms\Components\TextInput::make('discount')
                            ->label('Discount')
                            ->suffixIcon('heroicon-m-currency-euro')
                            ->disabled(),

                        Forms\Components\TextInput::make('amount')
                            ->label('Total price')
                            ->suffixIcon('heroicon-m-currency-euro')
                            ->numeric(2, ',', '.')
                            ->inputMode('integer')
                            ->readonly(),

                        Forms\Components\Radio::make('status')
                            ->options([
                                ActivityStatus::New->value => 'New',
                                ActivityStatus::Approved->value => 'Approved'
                            ])
                            ->descriptions([
                                ActivityStatus::New->value => 'When set, this Activity is a Draft and has to be validated.',
                                ActivityStatus::Approved->value => 'When set, the amount in this Activity record will be included in the balance calculation.'
                            ])
                            ->default(ActivityStatus::New->value)
                            ->disableOptionWhen(fn(string $value): bool => $value === ActivityStatus::Approved->value && !Auth::user()->is_admin
                            )
                            ->required()
                            ->columnSpan(2),
                    ])
                    ->columns(5)
                    ->collapsible()
                    ->compact(),
                Forms\Components\Section::make('Remarks')
                    ->icon('heroicon-m-pencil')
                    ->iconColor('info')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('')
                            ->autosize()
                            ->rows(5),
                    ])
                    ->collapsible()
                    ->compact(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions(['10', '25', '50'])
            ->columns([
                Tables\Columns\TextColumn::make('event')
                    ->label('Date')
                    ->date('D d/m/Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('plane.callsign')
                    ->label('Airplane')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('departure')
                    ->label('Departure')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('event_start')
                    ->label('OffBlock')
                    ->dateTime('H:i')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('arrival')
                    ->label('Arrival')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('event_stop')
                    ->label('OnBlock')
                    ->dateTime('H:i')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('PIC')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('split_cost')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('copilot.name')
                    ->label('CoPilot')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('full_counter')
                    ->label('Counter')
                    ->numeric(2, ',', '.')
                    ->searchable([
                        'counter_start', 'counter_stop'])
                    ->sortable([
                        'counter_start', 'counter_stop'])
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('warmup_minutes')
                    ->numeric(2, ',', '.')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('minutes')
                    ->label('Duration')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' min.')
                    ->alignEnd()
                    ->summarize([
                        CustomSummarizerMinutes::make()
                            ->label('Total Duration'),
                    ])
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->numeric(2, ',', '.')
                    ->alignEnd()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->label('')
                            ->numeric('2', ',', '.')
                            ->suffix(' €')
                    ])
                    ->suffix(' €')
                    ->toggleable(isToggledHiddenByDefault: false),
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('event', 'desc')
            ->persistSortInSession()
            ->filters([
                Tables\Filters\Filter::make('event')
                    ->form([
                        Forms\Components\DatePicker::make('event_from')
                            ->native(true)
                            ->reactive(),
                        Forms\Components\DatePicker::make('event_until')
                            ->native(true)
                            ->reactive(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['event_from'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('event', '>=', $date),
                            )
                            ->when(
                                $data['event_until'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('event', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['event_from'] ?? null) {
                            $indicators['event_from'] = 'Event from ' . \Illuminate\Support\Carbon::parse($data['event_from'])->toFormattedDateString();
                        }
                        if ($data['event_until'] ?? null) {
                            $indicators['event_until'] = 'Event until ' . Carbon::parse($data['event_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
                Tables\Filters\SelectFilter::make('plane.callsign')
                    ->label('Aircraft')
                    ->relationship('plane', 'callsign')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('user.name')
                    ->label('PIC')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('instructor.name')
                    ->label('Instructor')
                    ->relationship('instructor', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('current_year')
                    ->label('Current Year')
                    ->query(fn(Builder $query) => $query->whereYear('event', now()->year)
                    )
                    ->default(true), // Setzt den Filter standardmäßig aktiv
            ])
            ->persistFiltersInSession(false)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groups([
                Tables\Grouping\Group::make('event')
                    ->label('Date')
                    ->date('D d/m/Y')
                    ->collapsible(),
                Tables\Grouping\Group::make('status')
                    ->label('Status')
                    ->collapsible(),
            ]);
    }

    protected function setRequiredCounter(Get $get): bool
    {
        $selectedPlaneId = $get('plane_id') ?? '';
        $plane = Plane::find($selectedPlaneId) ?? '';
        if (!empty($selectedPlaneId)) {
            if ($plane->counter_type === '000') {
                return false;
            }
        }
        return true;
    }

    protected function setRequiredEventTime(Get $get): bool
    {
        $selectedPlaneId = $get('plane_id') ?? '';
        $plane = Plane::find($selectedPlaneId) ?? '';
        if (!empty($selectedPlaneId)) {
            if ($plane->counter_type === '100' or $plane->counter_type === '060') {
                return false;
            }
        }
        return true;
    }

    protected function calculateMinutesAndCosts(Get $get, Set $set): void
    {
        $selectedEngineOn = $get('event_start') ?? '';
        $selectedEngineOff = $get('event_stop') ?? '';
        $selectedWarmupCounter = $get('warmup_start') ?? '';
        $selectedCounterStart = $get('counter_start') ?? '';
        $selectedCounterStop = $get('counter_stop') ?? '';
        $selectedPlaneId = $get('plane_id') ?? '';
        $selectedUserId = $get('user_id') ?? '';
        $plane = Plane::find($selectedPlaneId) ?? '';
        $user = User::find($selectedUserId) ?? '';

        if (!empty($selectedPlaneId && $selectedUserId)) {
            if ($plane->counter_type === '000') {
                if (!empty($selectedEngineOn && $selectedEngineOff && $selectedPlaneId && $selectedUserId)) {
                    /** Calculate minutes between OffBlock/OnBlock time */
                    $warmup_minutes = 0;
                    $set('warmup_minutes', $warmup_minutes);
                    $minutes = Carbon::parse($selectedEngineOn)->diffInMinutes(Carbon::parse($selectedEngineOff));
                    $set('minutes', $minutes);
                    (new static())->calculateAmount($get, $set);
                }
            }

            if ($plane->counter_type === '100' or $plane->counter_type === '060') {
                /** Calculate minutes without warmup */
                if (!empty($selectedCounterStart && $selectedCounterStop && $selectedPlaneId && $selectedUserId) && empty($selectedWarmupCounter)) {
                    $minutes = 0;
                    $warmup_minutes = 0;
                    $set('warmup_minutes', $warmup_minutes);
                    /** industrial minutes calculation */
                    if ($plane->counter_type === '100') {
                        $calculateCounterDiff = $selectedCounterStop - $selectedCounterStart;
                        $minutes = round($calculateCounterDiff * 100 / 5 * 3, 2);
                        $set('minutes', $minutes);
                    }
                    /** Rolling hours and minutes with a decimal */
                    if ($plane->counter_type === '060') {
                        $calculateCounterDiff = (intval($selectedCounterStop * 60)) + ($selectedCounterStop * 100 % 100) - (intval($selectedCounterStart * 60)) + ($selectedCounterStart * 100 % 100);
                        $minutes = round($calculateCounterDiff, 2);
                        $set('minutes', $minutes);

                    }
                    (new static())->calculateAmount($get, $set);
                }
                /** Calculate minutes with warmup */
                if (!empty($selectedCounterStart && $selectedCounterStop && $selectedPlaneId && $selectedUserId && $selectedWarmupCounter)) {
                    $minutes = 0;
                    $warmup_minutes = 0;
                    /** industrial minutes calculation */
                    if ($plane->counter_type === '100') {
                        $calculateCounterWarmupDiff = $selectedCounterStart - $selectedWarmupCounter;
                        $warmup_minutes = round($calculateCounterWarmupDiff * 100 / 5 * 3, 2);
                        $set('warmup_minutes', $warmup_minutes);
                        $calculateCounterDiff = $selectedCounterStop - $selectedCounterStart;
                        $minutes = round($calculateCounterDiff * 100 / 5 * 3, 2);
                        $set('minutes', $minutes);

                    }
                    /** Rolling hours and minutes with a decimal */
                    if ($plane->counter_type === '060') {
                        $calculateCounterWarmupDiff = (intval($selectedCounterStart * 60)) + ($selectedCounterStart * 100 % 100) - (intval($selectedWarmupCounter * 60)) + ($selectedWarmupCounter * 100 % 100);
                        $warmup_minutes = round($calculateCounterWarmupDiff, 2);
                        $set('warmup_minutes', $warmup_minutes);
                        $calculateCounterDiff = (intval($selectedCounterStop * 60)) + ($selectedCounterStop * 100 % 100) - (intval($selectedCounterStart * 60)) + ($selectedCounterStart * 100 % 100);
                        $minutes = round($calculateCounterDiff, 2);
                        $set('minutes', $minutes);

                    }
                    (new static())->calculateAmount($get, $set);
                }
            }
        }
    }

    protected function calculateAmount(Get $get, Set $set): void
    {
        // Retrieve input values from the form using Filament's Get method
        $planeId = $get('plane_id');
        $userId = $get('user_id');
        $instructorId = $get('instructor_id'); // Selected instructor in the form
        $minutes = $get('minutes') ?? 0; // Default to 0 if minutes are not provided
        $warmupMinutes = $get('warmup_minutes') ?? 0; // Default to 0 if warmup minutes are not provided

        // Ensure the plane ID is provided
        if ($planeId) {
            // Fetch the Plane model based on the provided ID
            $plane = Plane::find($planeId);

            // If the plane does not exist, set default values and exit early
            if (!$plane) {
                $set('base_price_per_minute', 0);
                $set('instructor_price_per_minute', 0);
                $set('amount', 0);
                return;
            }

            // Default prices from the Plane model
            $basePrice = $plane->default_price_per_minute;
            $instructorPrice = 0; // Initialize instructor price to 0 by default

            // Fetch PlaneUser-specific pricing for the user
            if ($userId) {
                $planeUser = PlaneUser::where('plane_id', $planeId)
                    ->where('user_id', $userId)
                    ->first();

                // Use the PlaneUser model method to get the base price
                $basePrice = $planeUser?->getBasePricePerMinute() ?? $basePrice;

                // If an instructor is selected, fetch instructor price for the user
                if ($instructorId) {
                    $instructorPrice = $planeUser?->getInstructorPricePerMinute() ?? $plane->instructor_price_per_minute;
                }
            }

            // Update the form fields with the calculated prices
            $set('base_price_per_minute', $basePrice);
            $set('instructor_price_per_minute', $instructorPrice);

            // Calculate total time in minutes, including warmup minutes if applicable
            $totalMinutes = $plane->warmup_type == 0 ? $minutes : $minutes + $warmupMinutes;

            // Calculate the total amount: include instructor price only if selected
            $totalAmount = round(($basePrice + $instructorPrice) * $totalMinutes, 2);

            // Update the form field with the total amount
            $set('amount', $totalAmount);
        }
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

    public static function getWidgets(): array
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return [
//                ActivitiesTypeChart::class,
//                ActivitiesUserChart::class,
            ];
        } else {
            return [];
        }
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string)$modelClass::where('status', ActivityStatus::New)->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

}

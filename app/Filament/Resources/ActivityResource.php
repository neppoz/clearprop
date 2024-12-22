<?php

namespace App\Filament\Resources;

use App\Enums\ActivityStatus;
use App\Filament\Resources\ActivityResource\CustomSummarizerMinutes;
use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use App\Models\Plane;
use App\Models\User;
use App\Services\ActivityCalculationService;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
use Exception;
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
                Forms\Components\Section::make('Date & Crew')
                    ->icon('heroicon-m-globe-alt')
                    ->iconColor('info')
                    ->schema([
                        Forms\Components\DatePicker::make('event')
                            ->label('Date')
                            ->native(true)
                            ->reactive()
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(),

                        Forms\Components\Select::make('plane_id')
                            ->label('Aircraft')
                            ->preload()
                            ->native(false)
                            ->relationship('plane', 'callsign')
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(),

                        Forms\Components\Select::make('user_id')
                            ->label('PIC')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->options(User::all()->pluck('name', 'id')) // Load options for all users
                            ->default(fn() => Auth::user()->is_member ? Auth::id() : null) // Set default to current user for members
                            ->disabled(fn(): bool => Auth::user()->is_member) // Disable the field if the user is a member
                            ->saveRelationshipsWhenDisabled(true) // Ensure the value is saved even when the field is disabled
                            ->relationship(name: 'user', titleAttribute: 'name') // Define the relationship to the User model
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                // Trigger calculations after user_id is updated
                                (new static())->calculateMinutesAndCosts($get, $set);
                            })
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

                Forms\Components\Section::make('Trip')
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

                Forms\Components\Section::make('Hobbs')
                    ->icon('heroicon-m-cog')
                    ->iconColor('info')
                    ->schema([
                        Forms\Components\TextInput::make('warmup_start')
                            ->label('Warmup Counter Start')
                            ->numeric(2, ',', '.')
                            ->inputMode('decimal')
                            ->live(onBlur: true)
                            ->default(fn() => app(GeneralSettings::class)->engine_warmup ? 0 : null)
                            ->hidden(fn() => !app(GeneralSettings::class)->engine_warmup)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set)),

                        Forms\Components\TextInput::make('counter_start')
                            ->label('Counter Start')
                            ->numeric(2, ',', '.')
                            ->inputMode('decimal')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),

                        Forms\Components\TextInput::make('counter_stop')
                            ->label('Counter Stop')
                            ->numeric(2, ',', '.')
                            ->inputMode('decimal')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => (new static())->calculateMinutesAndCosts($get, $set))
                            ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),
                    ])
                    ->columns(app(GeneralSettings::class)->engine_warmup ? 3 : 2)
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

                Forms\Components\Section::make('Calculations')
                    ->icon('heroicon-m-variable')
                    ->iconColor('info')
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Placeholder::make('minutes')
                                    ->label('Minutes')
                                    ->inlineLabel()
                                    ->content(fn(Get $get) => $get('minutes') .
                                        ($get('minutes') >= 60
                                            ? ' (' . floor($get('minutes') / 60) . 'h ' . str_pad($get('minutes') % 60, 2, '0', STR_PAD_LEFT) . 'm)'
                                            : ''
                                        )
                                    ),

                                Forms\Components\Placeholder::make('warmup_minutes')
                                    ->label('Warmup minutes')
                                    ->inlineLabel()
                                    ->content(fn(Get $get) => $get('warmup_minutes') .
                                        ($get('warmup_minutes') >= 60
                                            ? ' (' . floor($get('warmup_minutes') / 60) . 'h ' . str_pad($get('warmup_minutes') % 60, 2, '0', STR_PAD_LEFT) . 'm)'
                                            : ''
                                        )
                                    )
                                    ->hidden(fn() => !app(GeneralSettings::class)->engine_warmup),

                                Forms\Components\Placeholder::make('amount')
                                    ->label('Total Price')
                                    ->inlineLabel()
                                    ->content(fn(Get $get) => number_format($get('amount'), 2, ',', '.') . ' €'),

                                Forms\Components\Placeholder::make('calculation_logic')
                                    ->label('Calculation Logic')
                                    ->inlineLabel()
                                    ->content(function (Get $get) {
                                        if ($get('package_name')) {
                                            return 'Package pricing';
                                        }

                                        $pricingType = $get('base_price_per_minute') > 0 ? 'Individual pricing' : 'Base pricing';
                                        $instructorPrice = $get('instructor_price_per_minute') > 0
                                            ? " + Instructor price ({$get('instructor_price_per_minute')} €/min)"
                                            : '';

                                        return "{$pricingType}{$instructorPrice}";
                                    }),

                                Forms\Components\Placeholder::make('package_name_placeholder')
                                    ->label('Package Name')
                                    ->inlineLabel()
                                    ->content(fn(Get $get) => $get('package_name'))
                                    ->hidden(fn(Get $get) => !$get('package_name')),

                                Forms\Components\Placeholder::make('remaining_time')
                                    ->label('Remaining Time')
                                    ->inlineLabel()
                                    ->content(function (Get $get) {
                                        $remainingMinutes = $get('remaining_minutes') ?? 0;
                                        $hours = floor($remainingMinutes / 60);
                                        $minutes = $remainingMinutes % 60;

                                        return "{$hours}h {$minutes}m";
                                    })
                                    ->hidden(fn(Get $get) => !$get('package_name'))

                            ])
                            ->columnSpan(1),

                        Forms\Components\Group::make()
                            ->schema([
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
                            ])
                            ->columnSpan(1),
//                        Forms\Components\Placeholder::make('base_price_per_minute')
//                            ->label('Base Price')
//                            ->inlineLabel()
//                            ->content(fn (Get $get) =>
//                            Plane::find($get('plane_id'))
//                                ? number_format(Plane::find($get('plane_id'))->default_price_per_minute, 2, ',', '.') . ' €'
//                                : 'N/A' // Fallback
//                            ),

//                        Forms\Components\TextInput::make('warmup_minutes')
//                            ->label('Warmup minutes')
//                            ->suffixIcon('heroicon-m-clock')
//                            ->numeric(2, ',', '.')
//                            ->inputMode('integer')
//                            ->hidden(fn () => !app(GeneralSettings::class)->engine_warmup)
//                            ->readonly()
//                            ->columnSpan(fn () => app(GeneralSettings::class)->engine_warmup ? 1 : 0),

//                        Forms\Components\TextInput::make('amount')
//                            ->label('Total')
//                            ->suffixIcon('heroicon-m-currency-euro')
//                            ->numeric(2, ',', '.')
//                            ->inputMode('integer')
//                            ->readonly()
//                            ->columnSpan(2),

//                        Forms\Components\Placeholder::make('base_price_per_minute')
//                            ->label('Base Price')
//                            ->inlineLabel()
//                            ->content(fn (Get $get) =>
//                                Plane::find($get('plane_id'))
//                                    ? number_format(Plane::find($get('plane_id'))->default_price_per_minute, 2, ',', '.') . ' €'
//                                    : 'N/A' // Fallback
//                            ),
//
//                        Forms\Components\TextInput::make('base_price_per_minute')
//                            ->label('Base Price')
//                            ->suffixIcon('heroicon-m-currency-euro')
//                            ->numeric(2, ',', '.')
//                            ->readonly()
//                            ->default(fn(Get $get) => Plane::find($get('plane_id'))->default_price_per_minute ?? 0),
//
//                        Forms\Components\TextInput::make('instructor_price_per_minute')
//                            ->label('Instructor price')
//                            ->suffixIcon('heroicon-m-currency-euro')
//                            ->numeric(2, ',', '.')
//                            ->readonly()
//                            ->default(fn(Get $get) => Plane::find($get('plane_id'))->instructor_price_per_minute ?? 0),
//
//                        Forms\Components\TextInput::make('discount')
//                            ->label('Package price')
//                            ->suffixIcon('heroicon-m-currency-euro')
//                            ->disabled(),

                    ])
                    ->columns(2)
                    ->collapsible()
                    ->compact(),
            ])
            ->columns(3);
    }

    /**
     * @throws Exception
     */
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
                    ->label('Warmup Minutes')
                    ->numeric(2, ',', '.')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->hidden(fn() => !app(GeneralSettings::class)->engine_warmup),

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

                Tables\Columns\TextColumn::make('package_used')
                    ->label('Package Used')
                    ->getStateUsing(fn(Model $record) => $record->package_id ? 'Yes' : 'No') // Display 'Yes' if a package was used
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('remaining_minutes')
                    ->label('Remaining Minutes')
                    ->getStateUsing(fn(Model $record) => $record->remaining_package_minutes > 0
                        ? $record->remaining_package_minutes . ' min'
                        : 'N/A') // Show remaining minutes or 'N/A'
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


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

    /**
     * Calculate minutes and costs for an activity, including package logic.
     *
     * @param Get $get Method to retrieve state values from the form.
     * @param Set $set Method to update state values in the form.
     */
    protected function calculateMinutesAndCosts(Get $get, Set $set): void
    {
        // Collect input data from the form
        $inputs = [
            'event_start' => $get('event_start'),
            'event_stop' => $get('event_stop'),
            'warmup_start' => $get('warmup_start'),
            'counter_start' => $get('counter_start'),
            'counter_stop' => $get('counter_stop'),
            'plane_id' => $get('plane_id'),
            'user_id' => $get('user_id'),
            'instructor_id' => $get('instructor_id'),
        ];

        // Skip calculation if essential inputs are missing
        if (empty($inputs['plane_id']) || empty($inputs['user_id'])) {
            $set('amount', 0);
            $set('minutes', 0);
            $set('warmup_minutes', 0);
            return;
        }

        $service = new ActivityCalculationService();

        // Calculate activity minutes
        $minutesData = $service->calculateMinutes($inputs);
        $set('minutes', $minutesData['minutes']);
        $set('warmup_minutes', $minutesData['warmup_minutes']);

        // Calculate costs, including package pricing
        $amountData = $service->calculateAmount($inputs, $minutesData['minutes'], $minutesData['warmup_minutes']);
        $set('amount', $amountData['amount']);
        $set('package_id', $amountData['package_id']);
        $set('package_name', $amountData['package_name']);
        $set('remaining_minutes', $amountData['remaining_minutes']);
        $set('package_used', $amountData['package_used']);
        $set('remaining_hours', $amountData['remaining_minutes']);
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

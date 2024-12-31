<?php

namespace App\Filament\Resources;

use App\Enums\ActivityStatus;
use App\Filament\Resources\ActivityResource\CustomSummarizerMinutes;
use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use App\Models\Plane;
use App\Models\User;
use App\Services\ActivityCalculationService;
use Carbon\Carbon;
use Filament\Forms;
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
use Illuminate\Support\Facades\Log;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function canViewAny(): bool
    {
        return Gate::allows('viewActivities');
    }

    public static function getSteps(): array
    {
        return [
            Forms\Components\Wizard\Step::make('General Information')
                ->completedIcon('heroicon-m-hand-thumb-up')
                ->schema([
                    Forms\Components\DatePicker::make('event')
                        ->label('Date')
                        ->native(true)
                        ->reactive()
                        ->required(),

                    Forms\Components\Select::make('plane_id')
                        ->label('Aircraft')
                        ->preload()
                        ->native(true)
                        ->reactive()
                        ->relationship('plane', 'callsign')
                        ->required(),

                    Forms\Components\Select::make('user_id')
                        ->label('PIC')
                        ->searchable()
                        ->preload()
                        ->native(true)
                        ->reactive()
                        ->options(User::all()->pluck('name', 'id'))
                        ->default(fn() => Auth::user()->is_member ? Auth::id() : null)
                        ->disabled(fn(): bool => Auth::user()->is_member)
                        ->saveRelationshipsWhenDisabled(true)
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->required(),

                    Forms\Components\Select::make('instructor_id')
                        ->label('Instructor')
                        ->preload()
                        ->native(true)
                        ->reactive()
                        ->searchable()
                        ->options(User::instructors()->pluck('name', 'id')),
                ])
                ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource())->calculateResults($get, $set))
                ->columns(2),

            Forms\Components\Wizard\Step::make('Flight Details')
                ->completedIcon('heroicon-m-hand-thumb-up')
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
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredEventTime($get)),

                    Forms\Components\TextInput::make('arrival')
                        ->label('Arrival')
                        ->maxLength(255),

                    Forms\Components\TimePicker::make('event_stop')
                        ->label('Engine Off')
                        ->seconds(false)
                        ->native(true)
                        ->reactive()
                        ->afterStateUpdated(fn(Set $set, Get $get, $state) => $get('event_start') && $state < $get('event_start')
                            ? $set('event_stop', null)
                            : null
                        )
                        ->minDate(fn(Get $get) => $get('event_start'))
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredEventTime($get)),
                ])
                ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource())->calculateResults($get, $set))
                ->columns(2),

            Forms\Components\Wizard\Step::make('Hobbs')
                ->completedIcon('heroicon-m-hand-thumb-up')
                ->schema([
                    Forms\Components\TextInput::make('counter_start')
                        ->label('Counter Start')
                        ->numeric(2, ',', '.')
                        ->inputMode('decimal')
                        ->minValue(1)
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),

                    Forms\Components\TextInput::make('counter_stop')
                        ->label('Counter Stop')
                        ->numeric(2, ',', '.')
                        ->inputMode('decimal')
                        ->minValue(fn(Get $get) => $get('counter_start'))
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),
                ])
                ->afterStateUpdated(fn(Get $get, Set $set) => (new ActivityResource())->calculateResults($get, $set))
                ->columns(2),

            Forms\Components\Wizard\Step::make('Remarks')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('Remarks')
                        ->autosize()
                        ->rows(5)->columnSpan(2),

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

                            Forms\Components\Placeholder::make('amount')
                                ->label('Total Price')
                                ->inlineLabel()
                                ->content(fn(Get $get) => number_format((float)($get('amount') ?? 0), 2, ',', '.') . ' €'),

                            Forms\Components\Placeholder::make('pricing_logic')
                                ->label('Pricelist')
                                ->inlineLabel()
                                ->content(fn(Get $get) => $get('pricing_logic') ?? 'N/A'),


                            Forms\Components\Placeholder::make('package_name')
                                ->label('Package Name')
                                ->inlineLabel()
                                ->content(fn(Get $get) => $get('package_name') ?? 'N/A')
                                ->hidden(fn(Get $get) => $get('package_used') == false),

                            Forms\Components\Placeholder::make('remaining_time')
                                ->label('Remaining minutes')
                                ->inlineLabel()
                                ->content(fn(Get $get) => $get('remaining_minutes') .
                                    ($get('remaining_minutes') >= 60
                                        ? ' (' . floor($get('remaining_minutes') / 60) . 'h ' . str_pad($get('minutes') % 60, 2, '0', STR_PAD_LEFT) . 'm)'
                                        : ''
                                    )
                                )
                                ->hidden(fn(Get $get) => $get('package_used') == false),

                            // Hidden fields in form, needed for saving remaining_minutes in mutator
                            Forms\Components\Hidden::make('minutes')
                                ->default(fn(Get $get) => $get('minutes') ?? null),
                            Forms\Components\Hidden::make('amount')
                                ->default(fn(Get $get) => $get('amount') ?? null),
                            Forms\Components\Hidden::make('package_used')
                                ->default(fn(Get $get) => $get('package_used') ?? false),
                            Forms\Components\Hidden::make('package_id')
                                ->default(fn(Get $get) => $get('package_id') ?? null),
                            Forms\Components\Hidden::make('remaining_minutes')
                                ->default(fn(Get $get) => $get('remaining_minutes') ?? null)


                        ]),

                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Radio::make('status')
                                ->options([
                                    ActivityStatus::New->value => 'New',
                                    ActivityStatus::Approved->value => 'Approved'
                                ])
                                ->default(ActivityStatus::New->value)
                                ->disableOptionWhen(fn(string $value): bool => Auth::user()->is_member)
                                ->required(),
                        ])
                ])
                ->columns(2)
        ];
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
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),

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

    public static function setRequiredCounter(Get $get): bool
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

    public static function setRequiredEventTime(Get $get): bool
    {
        $selectedPlaneId = $get('plane_id') ?? null;
        $plane = Plane::find($selectedPlaneId);

        if (!$plane) {
            return false;
        }

        return !in_array($plane->counter_type, ['100', '060']);
    }

    public function calculateResults(Get $get, Set $set): void
    {
        $inputs = $this->collectInputs($get);
        Log::channel('pricing')->info('Form inputs:', $inputs);
        $service = app(ActivityCalculationService::class);

        if ($service->validateInputs($inputs)) {
            $results = $service->calculate($inputs);
            Log::channel('pricing')->info('Return values from calculation:', $results);
            $set('pricing_logic', $results['pricing_logic']);
            $set('package_used', $results['package_used']);
            // If package_used is false, fallback the other package related fields
            $set('package_name', $results['package_used'] ? ($results['package_name'] ?? null) : 'N/A');
            $set('package_id', $results['package_used'] ? ($results['package_id'] ?? null) : null);
            $set('used_minutes', $results['package_used'] ? ($results['used_minutes'] ?? 0) : 0);
            $set('remaining_minutes', $results['package_used'] ? ($results['remaining_minutes'] ?? 0) : null);
            $set('minutes', $results['minutes']);
            $set('amount', $results['amount']);
        } else {
            $set('minutes', 0);
            $set('amount', 0);
        }
    }

    public function collectInputs(Get $get): array
    {
        return [
            'event' => $get('event'),
            'plane_id' => $get('plane_id'),
            'user_id' => $get('user_id'),
            'event_start' => $get('event_start'),
            'event_stop' => $get('event_stop'),
            'counter_start' => $get('counter_start'),
            'counter_stop' => $get('counter_stop'),
        ];
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

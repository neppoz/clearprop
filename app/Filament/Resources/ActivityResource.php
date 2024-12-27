<?php

namespace App\Filament\Resources;

use App\Enums\ActivityStatus;
use App\Filament\Resources\ActivityResource\CustomSummarizerMinutes;
use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use App\Models\Plane;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Get;
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

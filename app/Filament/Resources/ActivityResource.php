<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Activity;
use App\Services\ActivityCostService;
use App\Services\AssetsService;
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
                            ->relationship('plane', 'callsign')
                            ->required(),
                        Forms\Components\Select::make('type_id')
                            ->label('Type')
                            ->relationship('type', 'name')
                            ->required(),
                    ])
                    ->columns(3),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Toggle::make('split_cost')
                            ->inline()
                            ->default(false)
                            ->live(onBlur: true)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('user_id')
                            ->label('Pilot')
                            ->relationship('user', 'name')
                            ->required(),
                        Forms\Components\Select::make('copilot_id')
                            ->relationship('copilot', 'name')
                            ->required(fn(Get $get): bool => $get('split_cost')),
                        Forms\Components\Select::make('instructor_id')
                            ->disabled(fn(Get $get): bool => $get('split_cost'))
                            ->relationship('instructor', 'name'),

                    ])
                    ->columns(3),
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
                    ->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Toggle::make('engine_warmup')
                            ->inline()
                            ->default(false)
                            ->live(onBlur: true)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('warmup_start')
                            ->numeric()
                            ->inputMode('decimal')
                            ->visible(fn(Get $get): bool => $get('engine_warmup'))
                            ->required(fn(Get $get): bool => $get('engine_warmup')),
                        Forms\Components\TextInput::make('counter_start')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal'),
                        Forms\Components\TextInput::make('counter_stop')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal'),
                    ])
                    ->columnSpan(['lg' => fn(?Activity $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('warmup_minutes')
                            ->label('Warmup minutes')
                            ->visible(fn(Get $get): bool => $get('engine_warmup'))
                            ->content(fn(Activity $record): ?string => $record->warmup_minutes),
                        Forms\Components\Placeholder::make('minutes')
                            ->label('Minutes')
                            ->content(fn(Activity $record): ?string => $record->minutes),
                        Forms\Components\Placeholder::make('cost_minute')
                            ->label('Cost p.m')
                            ->content(fn(Activity $record): ?string => $record->rate . ' €'),
                        Forms\Components\Placeholder::make('amount')
                            ->label('Amount')
                            ->content(fn(Activity $record): ?string => $record->amount . ' €'),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Activity $record) => $record === null),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('description'),
                    ])
                    ->columnSpan(['lg' => fn(?Activity $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn(Activity $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn(Activity $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Activity $record) => $record === null),

            ])
            ->columns(3);
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
                    ->numeric(2)
                    ->searchable([
                        'counter_start', 'counter_stop'])
                    ->sortable([
                        'counter_start', 'counter_stop'])
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('warmup_minutes')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('minutes')
                    ->numeric()
                    ->alignEnd(),
                // TODO: Adding status, example in filament-demo
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
            ->defaultSort('id', 'desc')
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

    public static function calculatingRecords()
    {

    }

    public function calculateCosts(?Activity $record)
    {
        /** Calculate costs */
        try {
            (new ActivityCostService)->calculateCosts($record);
        } catch (Throwable $exception) {
            report($exception);
        }

        /** Update Asset hours */
        try {
            (new AssetsService())->calculateAssetsRunningHours($record->plane_id);
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}

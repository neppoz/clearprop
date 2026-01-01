<?php

namespace App\Filament\Resources;

use App\Enums\AssetCategory;
use App\Enums\AssetStatus;
use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;
    protected static ?int $navigationSort = 94;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function getLabel(): string
    {
        return __('assets.navigation.singular');
    }

    public static function getPluralLabel(): string
    {
        return __('assets.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('assets.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('assets.labels.plural');
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('viewAssets');
    }

    public static function getModelLabel(): string
    {
        return __('assets.labels.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('assets.labels.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('assets.sections.general'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('assets.fields.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('serial_number')
                            ->label(__('assets.fields.serial_number'))
                            ->maxLength(255),

                        Forms\Components\Select::make('category')
                            ->label(__('assets.fields.category'))
                            ->options(AssetCategory::class)
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label(__('assets.fields.status'))
                            ->options(AssetStatus::class)
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('assets.fields.notes'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('assets.sections.lifecycle'))
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label(__('assets.fields.start_date'))
                            ->native(false),

                        Forms\Components\DatePicker::make('end_date')
                            ->label(__('assets.fields.end_date'))
                            ->native(false),

                        Forms\Components\TextInput::make('start_hours')
                            ->label(__('assets.fields.start_hours'))
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('end_hours')
                            ->label(__('assets.fields.end_hours'))
                            ->numeric(),

                        Forms\Components\TextInput::make('current_running_hours')
                            ->label(__('assets.fields.current_running_hours'))
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('assets.sections.assignment'))
                    ->schema([
                        Forms\Components\Select::make('plane_id')
                            ->label(__('assets.fields.plane'))
                            ->relationship('plane', 'callsign')
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('assigned_to_id')
                            ->label(__('assets.fields.assigned_to'))
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('assets.sections.service'))
                    ->schema([
                        Forms\Components\TextInput::make('service_interval_hours')
                            ->label(__('assets.fields.service_interval_hours'))
                            ->numeric()
                            ->suffix('h'),

                        Forms\Components\TextInput::make('last_service_hours')
                            ->label(__('assets.fields.last_service_hours'))
                            ->numeric()
                            ->suffix('h'),

                        Forms\Components\DatePicker::make('last_service_date')
                            ->label(__('assets.fields.last_service_date'))
                            ->native(false),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('assets.fields.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('serial_number')
                    ->label(__('assets.fields.serial_number'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('category')
                    ->label(__('assets.fields.category'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('assets.fields.status'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('plane.callsign')
                    ->label(__('assets.fields.plane'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('assets.fields.assigned_to'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('current_running_hours')
                    ->label(__('assets.fields.current_running_hours'))
                    ->numeric()
                    ->sortable()
                    ->suffix(' h'),

                Tables\Columns\TextColumn::make('hours_until_service')
                    ->label(__('assets.fields.service_status'))
                    ->badge()
                    ->color(fn (Asset $record): string => match ($record->service_status) {
                        'overdue' => 'danger',
                        'due_soon' => 'warning',
                        'ok' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (Asset $record): string => match ($record->service_status) {
                        'no_interval' => '-',
                        'overdue' => __('assets.service.overdue') . ' (' . abs($record->hours_until_service) . 'h)',
                        'due_soon' => $record->hours_until_service . 'h',
                        'ok' => $record->hours_until_service . 'h',
                        default => '-',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('assets.fields.start_date'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('assets.fields.end_date'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('assets.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('assets.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(AssetCategory::class)
                    ->label(__('assets.fields.category')),

                Tables\Filters\SelectFilter::make('status')
                    ->options(AssetStatus::class)
                    ->label(__('assets.fields.status')),

                Tables\Filters\SelectFilter::make('plane')
                    ->relationship('plane', 'callsign')
                    ->label(__('assets.fields.plane'))
                    ->preload(),

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
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
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

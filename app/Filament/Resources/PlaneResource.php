<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaneResource\Pages;
use App\Models\Plane;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;
use App\Settings\GeneralSettings;

class PlaneResource extends Resource
{
    protected static ?string $model = Plane::class;
    protected static ?int $navigationSort = 98;
    protected static ?string $recordTitleAttribute = 'callsign';
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    public static function getLabel(): string
    {
        return __('planes.navigation.singular');
    }

    public static function getPluralLabel(): string
    {
        return __('planes.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('planes.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('planes.labels.plural');
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('viewAircrafts');
    }

    public static function getModelLabel(): string
    {
        return __('planes.labels.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('planes.labels.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('callsign')
                    ->label(__('planes.fields.callsign'))
                    ->autocapitalize('words')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('vendor')
                    ->label(__('planes.fields.vendor'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('model')
                    ->label(__('planes.fields.model'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('prodno')
                    ->label(__('planes.fields.production_number'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('default_price_per_minute')
                    ->label(__('planes.fields.base_price'))
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->default(0)
                    ->suffix(' €'),

                Forms\Components\TextInput::make('instructor_price_per_minute')
                    ->label(__('planes.fields.instructor_price'))
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->default(0)
                    ->suffix(' €'),

                Forms\Components\Select::make('counter_type')
                    ->label(__('planes.fields.counter_type'))
                    ->options(Plane::COUNTER_TYPE_SELECT)
                    ->required(),

                Forms\Components\Toggle::make('active')
                    ->label(__('planes.fields.active'))
                    ->default(true)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('callsign')
                    ->label(__('planes.fields.callsign'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('vendor')
                    ->label(__('planes.fields.vendor'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('model')
                    ->label(__('planes.fields.model'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('prodno')
                    ->label(__('planes.fields.production_number'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('default_price_per_minute')
                    ->label(__('planes.fields.base_price'))
                    ->searchable()
                    ->suffix(' €')
                    ->sortable(),

                Tables\Columns\TextColumn::make('instructor_price_per_minute')
                    ->label(__('planes.fields.instructor_price'))
                    ->searchable()
                    ->suffix(' €')
                    ->sortable(),

                Tables\Columns\TextColumn::make('counter_type')
                    ->label(__('planes.fields.counter_type'))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('pilot_paying_warmup')
                    ->label(__('planes.fields.pilot_paying_warmup'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('warmup_minutes')
                    ->label(__('planes.fields.warmup_minutes'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric(),

                Tables\Columns\IconColumn::make('active')
                    ->label(__('planes.fields.active'))
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('planes.fields.created_at'))
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('planes.fields.updated_at'))
                    ->dateTime()
                    ->searchable()
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
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanes::route('/'),
            'create' => Pages\CreatePlane::route('/create'),
            'edit' => Pages\EditPlane::route('/{record}/edit'),
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

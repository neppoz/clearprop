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
    protected static ?string $recordTitleAttribute = 'Aircrafts';
    protected static ?string $navigationLabel = 'Aircrafts';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    public static function canViewAny(): bool
    {
        return Gate::allows('viewAircrafts');
    }

    public static function getModelLabel(): string
    {
        return 'Aircraft';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Aircrafts';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('callsign')
                    ->autocapitalize('words')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('vendor')
                    ->label('Vendor')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('model')
                    ->label('Model')
                    ->maxLength(255),

                Forms\Components\TextInput::make('prodno')
                    ->label('Production Number')
                    ->maxLength(255),

                Forms\Components\TextInput::make('default_price_per_minute')
                    ->label('Base price')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->default(0)
                    ->suffix(' €'),

                Forms\Components\TextInput::make('instructor_price_per_minute')
                    ->label('Instructor price')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->default(0)
                    ->suffix(' €'),

                Forms\Components\Select::make('counter_type')
                    ->label('Counter Type')
                    ->options(Plane::COUNTER_TYPE_SELECT)
                    ->required(),

                Forms\Components\Toggle::make('active')
                    ->label('Active')
                    ->default(true)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('callsign')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('vendor')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('model')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('prodno')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('default_price_per_minute')
                    ->label('Base price')
                    ->searchable()
                    ->suffix(' €')
                    ->sortable(),

                Tables\Columns\TextColumn::make('instructor_price_per_minute')
                    ->label('Instructor price')
                    ->searchable()
                    ->suffix(' €')
                    ->sortable(),

                Tables\Columns\TextColumn::make('counter_type')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('pilot_paying_warmup')
                    ->label('Pilot Paying Warmup')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('warmup_minutes')
                    ->label('Warmup Minutes')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric(),

                Tables\Columns\IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
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

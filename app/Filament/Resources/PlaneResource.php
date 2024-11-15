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

class PlaneResource extends Resource
{
    protected static ?string $model = Plane::class;

    protected static ?int $navigationSort = 98;

    protected static ?string $recordTitleAttribute = 'Aircrafts';
    protected static ?string $navigationLabel = 'Aircrafts';
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static bool $shouldCollapseNavigationGroup = true;
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
                Forms\Components\Select::make('counter_type')
                    ->label('Counter Type')
                    ->options(Plane::COUNTER_TYPE_SELECT)
                    ->required(),
                Forms\Components\Toggle::make('warmup_type')
                    ->label('Pilot paying')
                    ->hint('Select if the engine warmup has to be charged to the pilot'),
                Forms\Components\Toggle::make('active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('callsign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vendor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prodno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('counter_type')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('warmup_type')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
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
        return [
            //
        ];
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

<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Enums\RatingStatus;
use App\Models\Plane;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanesRelationManager extends RelationManager
{
    protected static string $relationship = 'planes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('callsign')
                    ->label('Callsign')
                    ->disabled(),

                Forms\Components\TextInput::make('base_price_per_minute')
                    ->label('Base price')
                    ->numeric(2, ',', '.')
                    ->required(),

                Forms\Components\TextInput::make('instructor_price_per_minute')
                    ->label('Instructor price')
                    ->numeric(2, ',', '.')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('callsign')
            ->columns([
                Tables\Columns\TextColumn::make('callsign'),
                Tables\Columns\TextColumn::make('base_price_per_minute'),
                Tables\Columns\TextColumn::make('instructor_price_per_minute'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn(AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('base_price_per_minute')
                            ->label('Base price')
                            ->numeric(2, ',', '.')
                            ->required(),
                        Forms\Components\TextInput::make('instructor_price_per_minute')
                            ->label('Instructor price')
                            ->numeric(2, ',', '.')
                            ->required(),
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->groupedBulkActions([
            ]);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use App\Models\Shop\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('reservation_start')
                    ->required(),
                Forms\Components\DateTimePicker::make('reservation_stop')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('mode_id')
                    ->relationship('mode', 'name')
                    ->required()
                    ->default(1),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('slot_id')
                    ->relationship('slot', 'title'),
                Forms\Components\Toggle::make('checkin'),
                Forms\Components\TextInput::make('seats')
                    ->numeric(),
                Forms\Components\TextInput::make('seats_taken')
                    ->numeric(),
                Forms\Components\TextInput::make('seats_available')
                    ->numeric(),
                Forms\Components\Toggle::make('instructor_needed'),
                Forms\Components\Select::make('plane_id')
                    ->relationship('plane', 'id')
                    ->required(),
                Forms\Components\Select::make('created_by_id')
                    ->relationship('created_by', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plane.callsign')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservation_start')
                    ->label('From')
                    ->searchable()
                    ->sortable()
                    ->dateTime('D d/m - H:i'),
                Tables\Columns\TextColumn::make('reservation_stop')
                    ->label('To')
                    ->searchable()
                    ->sortable()
                    ->dateTime('D d/m - H:i'),
                Tables\Columns\TextColumn::make('mode.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Charter' => 'primary',
                        'School' => 'gray',
                        'Maintenance' => 'danger',
                    }),
//                Tables\Columns\TextColumn::make('status')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('slot.title')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\IconColumn::make('checkin')
//                    ->boolean(),
//                Tables\Columns\TextColumn::make('seats')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('seats_taken')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('seats_available')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\IconColumn::make('instructor_needed')
//                    ->boolean(),
                Tables\Columns\TextColumn::make('created_by.name')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    /** @return Builder<Order> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
    }
}

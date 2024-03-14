<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Reservation;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Reservation';

    protected static ?string $navigationLabel = 'Reservation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make('plane_id')
//                    ->badge(),
//                Tables\Columns\TextColumn::make(Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), 'reservation_start')->format('Y-m-d H:i:s'))
//                    ->searchable()
//                    ->sortable()
//                    ->date(),
//                Tables\Columns\TextColumn::make('reservation_stop')
//                    ->searchable()
//                    ->sortable()
//                    ->date(),
//                Tables\Columns\TextColumn::make('description')
//                    ->searchable()
//                    ->sortable()
//                    ->toggleable(),
//                Tables\Columns\TextColumn::make('mode_id')
//                    ->badge(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

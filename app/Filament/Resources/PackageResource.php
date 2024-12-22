<?php

namespace App\Filament\Resources;

use App\Enums\PackageType;
use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Package Name')
                    ->required()
                    ->maxLength(255),

                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),

                TextInput::make('price')
                    ->label('Price (€)')
                    ->numeric()
                    ->required(),

                TextInput::make('hours')
                    ->label('Hours')
                    ->numeric()
                    ->required(),

                DatePicker::make('valid_from')
                    ->label('Valid From')
                    ->required(),

                DatePicker::make('valid_until')
                    ->label('Valid Until')
                    ->required(),

                Select::make('type')
                    ->label('Package Type')
                    ->options([
                        PackageType::HOURLY->value => 'Hourly',
                        PackageType::FIXED->value => 'Fixed Price',
                    ])
                    ->required(),

                Select::make('plane_id')
                    ->label('Plane')
                    ->relationship('plane', 'callsign')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->nullable(),

                Select::make('instructor_id')
                    ->label('Instructor')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->options(User::instructors()->pluck('name', 'id'))
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Package Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('PIC')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price (€)')
                    ->sortable()
                    ->numeric(),

                Tables\Columns\TextColumn::make('hours')
                    ->label('Hours')
                    ->sortable()
                    ->numeric()
                    ->suffix(' h'),

                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Valid From')
                    ->date(),

                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Valid Until')
                    ->date(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('plane.callsign')
                    ->label('Plane')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('valid_until')
                    ->label('Active Packages')
                    ->query(fn($query) => $query->whereDate('valid_until', '>=', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}

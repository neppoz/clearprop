<?php

namespace App\Filament\Resources;

use App\Enums\PackageType;
use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use App\Models\User;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Gate;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 99;

    public static function canViewAny(): bool
    {
        return Gate::allows('viewPackages');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Package Name')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('Package Type')
                    ->options([
//                        PackageType::HOURLY->value => 'Hourly',
                        PackageType::FIXED->value => 'Fixed Price',
                    ])
                    ->required(),

                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->native(true)
                    ->required(),

                Select::make('plane_id')
                    ->label('Plane')
                    ->relationship('plane', 'callsign')
                    ->searchable()
                    ->preload()
                    ->native(true)
                    ->nullable(),

                DatePicker::make('valid_from')
                    ->label('Valid From')
                    ->native(true)
                    ->required(),

                DatePicker::make('valid_until')
                    ->label('Valid Until')
                    ->native(true)
                    ->required(),

                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->suffix('€')
                    ->required(),

                TextInput::make('initial_minutes')
                    ->label('Minutes included')
                    ->numeric()
                    ->required(),

                Toggle::make('instructor_included')
                    ->label('Instructor included')
                    ->helperText('Indicate if an instructor is included in this activity.')
                    ->reactive()
                    ->default(false),

                TextInput::make('remaining_minutes')
                    ->label('Remaining minutes')
                    ->numeric()
                    ->required(),
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

                Tables\Columns\TextColumn::make('plane.callsign')
                    ->label('Plane')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->numeric(2, ',', '.')
                    ->suffix(' €'),

                Tables\Columns\TextColumn::make('initial_minutes')
                    ->label('Included')
                    ->sortable()
                    ->getStateUsing(fn($record) => self::formatMinutesToHoursAndMinutes($record->initial_minutes)),

                Tables\Columns\TextColumn::make('remaining_minutes')
                    ->label('Remaining')
                    ->sortable()
                    ->getStateUsing(fn($record) => self::formatMinutesToHoursAndMinutes($record->remaining_minutes)),

                Tables\Columns\IconColumn::make('instructor_included')
                    ->label('Instructor')
                    ->boolean()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Valid From')
                    ->date(),

                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Valid Until')
                    ->date(),
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

    protected static function formatMinutesToHoursAndMinutes(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($remainingMinutes === 0) {
            return "{$hours}h"; // Nur Stunden anzeigen
        }

        return "{$hours}h " . str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) . "m"; // Stunden und Minuten mit führender Null
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

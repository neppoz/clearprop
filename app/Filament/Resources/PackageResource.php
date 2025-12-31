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
    protected static ?int $navigationSort = 99;

    public static function getLabel(): string
    {
        return __('packages.navigation.singular');
    }

    public static function getPluralLabel(): string
    {
        return __('packages.navigation.singular');
    }

    public static function getNavigationLabel(): string
    {
        return __('packages.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('packages.navigation_group');
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('viewPackages');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('packages.fields.name'))
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label(__('packages.fields.type'))
                    ->options([
//                        PackageType::HOURLY->value => 'Hourly',
                        PackageType::FIXED->value => __('packages.fields.type_fixed'),
                    ])
                    ->required(),

                Select::make('user_id')
                    ->label(__('packages.fields.user'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->native(true)
                    ->required(),

                Select::make('plane_id')
                    ->label(__('packages.fields.plane'))
                    ->relationship('plane', 'callsign')
                    ->searchable()
                    ->preload()
                    ->native(true)
                    ->nullable(),

                DatePicker::make('valid_from')
                    ->label(__('packages.fields.valid_from'))
                    ->native(true)
                    ->required(),

                DatePicker::make('valid_until')
                    ->label(__('packages.fields.valid_until'))
                    ->native(true)
                    ->required(),

                TextInput::make('price')
                    ->label(__('packages.fields.price'))
                    ->numeric()
                    ->suffix('€')
                    ->required(),

                TextInput::make('initial_minutes')
                    ->label(__('packages.fields.minutes_included'))
                    ->numeric()
                    ->required(),

                Toggle::make('instructor_included')
                    ->label(__('packages.fields.instructor_included'))
                    ->helperText(__('packages.fields.instructor_included_helper'))
                    ->reactive()
                    ->default(false),

                TextInput::make('remaining_minutes')
                    ->label(__('packages.fields.remaining_minutes'))
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('packages.fields.name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('packages.fields.pic'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('plane.callsign')
                    ->label(__('packages.fields.plane'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label(__('packages.fields.price'))
                    ->sortable()
                    ->numeric(2, ',', '.')
                    ->suffix(' €'),

                Tables\Columns\TextColumn::make('initial_minutes')
                    ->label(__('packages.fields.included'))
                    ->sortable()
                    ->getStateUsing(fn($record) => self::formatMinutesToHoursAndMinutes($record->initial_minutes)),

                Tables\Columns\TextColumn::make('remaining_minutes')
                    ->label(__('packages.fields.remaining'))
                    ->sortable()
                    ->getStateUsing(fn($record) => self::formatMinutesToHoursAndMinutes($record->remaining_minutes)),

                Tables\Columns\IconColumn::make('instructor_included')
                    ->label(__('packages.fields.instructor'))
                    ->boolean()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('valid_from')
                    ->label(__('packages.fields.valid_from'))
                    ->date(),

                Tables\Columns\TextColumn::make('valid_until')
                    ->label(__('packages.fields.valid_until'))
                    ->date(),
            ])
            ->filters([
                Tables\Filters\Filter::make('valid_until')
                    ->label(__('packages.fields.active_packages'))
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

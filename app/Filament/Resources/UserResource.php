<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static bool $shouldCollapseNavigationGroup = true;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\DatePicker::make('medical_due'),
                                Forms\Components\TextInput::make('license')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make('Contact details')
                            ->schema([
                                Forms\Components\TextInput::make('phone_1')
                                    ->tel()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone_2')
                                    ->tel()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('address')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('city')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('taxno')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => fn(?User $record) => $record === null ? 3 : 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Login')
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->label('Email address')
                                    ->required()
                                    ->maxLength(255)
                                    ->email()
                                    ->unique(User::class, 'email', ignoreRecord: true),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->dehydrated(fn($state) => filled($state))
                                    ->required(fn(string $context): bool => $context === 'create'),
                                Forms\Components\Select::make('lang')
                                    ->options(User::LANG_SELECT)
                                    ->required(),
                            ])
                            ->columnSpan(['lg' => fn(?User $record) => $record === null ? 3 : 2]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn(User $record): ?string => $record->created_at?->diffForHumans()),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn(User $record): ?string => $record->updated_at?->diffForHumans()),
                                Forms\Components\Placeholder::make('email_verified_at')
                                    ->label('Email verified')
                                    ->content(fn(User $record): ?string => $record->email_verified_at),
                                Forms\Components\Placeholder::make('privacy_confirmed_at')
                                    ->label('Privacy confirmed')
                                    ->content(fn(User $record): ?string => $record->privacy_confirmed_at),
                            ])
                            ->hidden(fn(?User $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1])

            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->searchable()
                            ->sortable()
                            ->weight('medium')
                            ->alignLeft(),

                        Tables\Columns\TextColumn::make('email')
                            ->label('Email address')
                            ->searchable()
                            ->sortable()
                            ->color('gray')
                            ->alignLeft(),
                    ])->space(),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('phone_1')
                            ->icon('heroicon-m-device-phone-mobile')
                            ->label('Mobile')
                            ->alignLeft(),

                        Tables\Columns\TextColumn::make('phone_2')
                            ->icon('heroicon-m-phone')
                            ->label('Office')
                            ->alignLeft(),
                    ])->space(2),
                ])->from('md'),
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
            RelationManagers\PlanesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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

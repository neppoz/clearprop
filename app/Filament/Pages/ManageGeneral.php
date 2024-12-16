<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\Gate;

class ManageGeneral extends SettingsPage
{
    protected static ?string $label = 'General Settings';
    protected static ?string $title = 'General Settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $settings = GeneralSettings::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'General Settings';
    protected static ?int $navigationSort = 100;

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('viewSettings');
    }

    public static function canView(): bool
    {
        return Gate::allows('viewSettings');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\Checkbox::make('check_medical')
                            ->label('Check medical validity'),
//                        Forms\Components\Checkbox::make('check_ratings')
//                            ->label('Check aircraft ratings'),
                    ]),

                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\Checkbox::make('check_activities')
                            ->label('Check airworthiness'),
                        Forms\Components\TextInput::make('check_activities_limit_days')
                            ->label('Grounded limit')
                            ->suffix('days')
                            ->numeric(2, ',', '.'),
                    ]),

                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\Checkbox::make('check_balance')
                            ->label('Check finances'),
                        Forms\Components\TextInput::make('check_balance_limit_amount')
                            ->label('Credit limit')
                            ->suffixIcon('heroicon-m-currency-euro')
                            ->numeric(2, ',', '.'),
                    ]),

            ]);
    }
}

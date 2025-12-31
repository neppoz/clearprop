<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\Gate;

class ManageGeneral extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $settings = GeneralSettings::class;
    protected static ?int $navigationSort = 100;

    public static function getNavigationGroup(): ?string
    {
        return __('settings.general.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('settings.general.navigation_label');
    }

    public static function getLabel(): string
    {
        return __('settings.general.title');
    }

    public function getTitle(): string
    {
        return __('settings.general.title');
    }

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
                Forms\Components\Fieldset::make(__('settings.general.sections.reservations'))
                    ->label(__('settings.general.sections.reservations'))
                    ->columns(2)
                    ->schema([
                        Forms\Components\Checkbox::make('check_medical')
                            ->label(__('settings.general.fields.check_medical'))
                            ->helperText(__('settings.general.fields.check_medical_helper'))
                            ->columnSpan(2),
                        Forms\Components\Checkbox::make('check_activities')
                            ->label(__('settings.general.fields.check_airworthiness'))
                            ->helperText(__('settings.general.fields.check_airworthiness_helper'))
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('check_activities_limit_days')
                            ->label(__('settings.general.fields.airworthiness_limit_days'))
                            ->suffix(__('settings.general.suffixes.days'))
                            ->numeric(2, ',', '.')
                            ->columnSpan(2),
                        Forms\Components\Checkbox::make('check_balance')
                            ->label(__('settings.general.fields.check_balance'))
                            ->helperText(__('settings.general.fields.check_balance_helper'))
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('check_balance_limit_amount')
                            ->label(__('settings.general.fields.balance_limit_amount'))
                            ->suffixIcon('heroicon-m-currency-euro')
                            ->numeric(2, ',', '.')
                            ->columnSpan(2),
                    ]),
            ]);
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $profileData = [];

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->getUser()->name,
            'email' => $this->getUser()->email,
            'medical_due' => $this->getUser()->medical_due,
            'phone_1' => $this->getUser()->phone_1,
            'phone_2' => $this->getUser()->phone_2,
            'address' => $this->getUser()->address,
            'city' => $this->getUser()->city,
            'taxno' => $this->getUser()->taxno,
        ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->schema([

                    Section::make(__('user.sections.profile'))
                        ->description(__('user.sections.profile_description'))
                        ->schema([
                            TextInput::make('name')
                                ->label(__('user.fields.name'))
                                ->required(),

                            TextInput::make('email')
                                ->label(__('user.fields.email'))
                                ->email()
                                ->disabled()
                                ->dehydrated(false)
                                ->helperText(__('user.helper.email_fixed')),

                            DatePicker::make('medical_due')
                                ->label(__('user.fields.medical_due'))
                                ->native()
                                ->required(),

                            TextInput::make('phone_1')
                                ->label(__('user.fields.phone_1'))
                                ->tel()
                                ->maxLength(255),

                            TextInput::make('phone_2')
                                ->label(__('user.fields.phone_2'))
                                ->tel()
                                ->maxLength(255),

                            TextInput::make('address')
                                ->label(__('user.fields.address'))
                                ->maxLength(255),

                            TextInput::make('city')
                                ->label(__('user.fields.city'))
                                ->maxLength(255),

                            TextInput::make('taxno')
                                ->label(__('user.fields.taxno'))
                                ->maxLength(255),
                        ])
                        ->columns(2),

                    Section::make(__('user.sections.password'))
                        ->description(__('user.sections.password_description'))
                        ->schema([
                            TextInput::make('current_password')
                                ->label(__('user.fields.current_password'))
                                ->password()
                                ->revealable()
                                ->required()
                                ->currentPassword(),

                            TextInput::make('password')
                                ->label(__('user.fields.password'))
                                ->password()
                                ->revealable()
                                ->required()
                                ->rule(Password::defaults())
                                ->autocomplete('new-password')
                                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                ->live(debounce: 500)
                                ->same('password_confirmation'),

                            TextInput::make('password_confirmation')
                                ->label(__('user.fields.password_confirmation'))
                                ->password()
                                ->revealable()
                                ->required()
                                ->dehydrated(false),
                        ]),
                ])
                ->statePath('profileData')
                ->model($this->getUser()),
        ];
    }

    public function saveProfile(): void
    {
        $this->getUser()->update([
            'name' => $this->profileData['name'],
            'medical_due' => $this->profileData['medical_due'],
            'phone_1' => $this->profileData['phone_1'],
            'phone_2' => $this->profileData['phone_2'],
            'address' => $this->profileData['address'],
            'city' => $this->profileData['city'],
            'taxno' => $this->profileData['taxno'],
        ]);

        Notification::make()
            ->title(__('user.notifications.profile_updated'))
            ->success()
            ->send();

    }

    public function savePassword(): void
    {
        $this->validate([
            'profileData.current_password' => ['required', 'current_password'],
            'profileData.password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $this->getUser()->update([
            'password' => Hash::make($this->profileData['password']),
        ]);

        Filament::auth()->login($this->getUser());

        $this->profileData['password'] = '';
        $this->profileData['current_password'] = '';
        $this->profileData['password_confirmation'] = '';

        Notification::make()
            ->title(__('user.notifications.password_updated'))
            ->success()
            ->send();

        $this->redirect(static::getUrl());
    }


    protected function getUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Filament::auth()->user();
    }

    public function getHeaderWidgets(): array
    {
        return [];
    }
}

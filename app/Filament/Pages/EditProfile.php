<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Widgets\UserBalance;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $passwordData = [];
    public ?array $profileData = [];

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->getUser()->name,
            'email' => $this->getUser()->email,
        ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->schema([
                    Section::make('Profile Information')
                        ->description('Update your account\'s profile information and email address.')
                        ->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(table: 'users', column: 'email', ignoreRecord: true)
                                ->rule(function () {
                                    return 'unique:users,email,' . $this->getUser()->id;
                                }),
                        ]),

                    Section::make('Update Password')
                        ->description('Ensure your account is using a long, random password to stay secure.')
                        ->schema([
                            TextInput::make('current_password')
                                ->password()
                                ->required()
                                ->currentPassword(),
                            TextInput::make('password')
                                ->password()
                                ->required()
                                ->rule(Password::defaults()) // Standard Laravel Passwort-Regeln
                                ->autocomplete('new-password')
                                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                ->live(debounce: 500)
                                ->same('password_confirmation'),
                            TextInput::make('password_confirmation')
                                ->password()
                                ->required()
                                ->dehydrated(false),
                        ]),
                ])
                ->statePath('profileData')
                ->model($this->getUser()),
        ];
    }

    protected function getUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Filament::auth()->user();
    }

    public function saveProfile(): void
    {
        $this->getUser()->update($this->form->getState());
        Filament::notify('success', 'Profile updated successfully.');
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

        // Zurücksetzen der Passwort-Felder nach dem Speichern
        $this->profileData['password'] = '';
        $this->profileData['current_password'] = '';
        $this->profileData['password_confirmation'] = '';

        Filament::notify('success', 'Password updated successfully.');
    }

    public function getHeaderWidgets(): array
    {
        return [
            UserBalance::class,
        ];
    }
}

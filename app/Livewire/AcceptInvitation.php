<?php

namespace App\Livewire;

use App\Models\Invitation;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Dashboard;
use Filament\Pages\SimplePage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AcceptInvitation extends SimplePage
{
    use InteractsWithForms;

    protected static string $view = 'livewire.accept-invitation';

    public int $invitation;
    public ?array $data = [];
    private ?Invitation $invitationModel = null;

    public function mount(): void
    {
        $this->invitationModel = Invitation::find($this->invitation);

        if (!$this->invitationModel) {
            abort(404, 'Invalid invitation.');
        }

        $this->form->fill([
            'email' => $this->invitationModel->email,
        ]);
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament-panels::pages/auth/register.form.name.label'))
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                TextInput::make('email')
                    ->label(__('filament-panels::pages/auth/register.form.email.label'))
                    ->disabled(),

                TextInput::make('password')
                    ->label(__('filament-panels::pages/auth/register.form.password.label'))
                    ->password()
                    ->required()
                    ->rule(Password::default())
                    ->same('passwordConfirmation')
                    ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),

                TextInput::make('passwordConfirmation')
                    ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
                    ->password()
                    ->required()
                    ->dehydrated(false),

                DatePicker::make('medical_due')
                    ->label('Due date medical')
                    ->native(true)
                    ->reactive(),

                TextInput::make('phone_1')
                    ->label('Mobile')
                    ->required()
                    ->rule('regex:/^\+?[0-9]{1,3}?[0-9]{6,14}$/')
                    ->helperText('Enter a valid phone number (e.g., +39123456789).'),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        if (auth()->check()) {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        $this->invitationModel = Invitation::find($this->invitation);

        if (!$this->invitationModel) {
            abort(404, 'Invalid invitations.');
        }

        $user = User::create([
            'name' => $this->form->getState()['name'],
            'password' => Hash::make($this->form->getState()['password']),
            'email' => $this->invitationModel->email,
            'medical_due' => $this->form->getState()['medical_due'],
            'phone_1' => $this->form->getState()['phone_1'],
            'email_verified_at' => now(),
        ]);

        $user->assignRole(User::IS_MEMBER);

        auth()->login($user);

        $this->invitationModel->delete();

        $this->redirect(route('filament.panel.pages.dashboard'));
    }

    public function getHeading(): string
    {
        return __('Accept Invitation');
    }

    public function getSubHeading(): string
    {
        return __('Create your user to accept the invitation');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('register')
                ->label(__('filament-panels::pages/auth/register.form.actions.register.label'))
                ->submit('register'),
        ];
    }
}

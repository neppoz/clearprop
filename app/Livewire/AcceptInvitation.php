<?php

namespace App\Livewire;

use App\Models\Invitation;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Dashboard;
use Filament\Pages\SimplePage;
use Illuminate\Validation\Rules\Password;

class AcceptInvitation extends SimplePage
{
    use InteractsWithForms;
    use InteractsWithFormActions;

    protected static string $view = 'livewire.accept-invitation';

    public int $invitation;
    public ?array $data = [];
    private Invitation $invitationModel;

    public function mount(): void
    {
        $this->invitationModel = Invitation::findOrFail($this->invitation);

        $this->form->fill([
            'email' => $this->invitationModel->email
        ]);
    }

    public function form(Form $form): Form
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
                    ->label('Due date medical'),
                TextInput::make('phone_1')
                    ->label('Mobile')
                    ->required(),
                Select::make('lang')
                    ->options(User::LANG_SELECT)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $this->invitationModel = Invitation::find($this->invitation);

        $user = User::create([
            'name' => $this->form->getState()['name'],
            'password' => $this->form->getState()['password'],
            'email' => $this->invitationModel->email,
            'medical_due' => $this->form->getState()['medical_due'],
            'phone_1' => $this->form->getState()['phone_1'],
            'lang' => $this->form->getState()['lang']
        ]);

        $user->roles()->attach(User::IS_MEMBER);

        auth()->login($user);

        $this->invitationModel->delete();

        $this->redirect(Dashboard::getUrl());
    }

    public function getHeading(): string
    {
        return 'Accept Invitation';
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function getSubHeading(): string
    {
        return 'Create your user to accept the invitation';
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction(),
        ];
    }

    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->label(__('filament-panels::pages/auth/register.form.actions.register.label'))
            ->submit('register');
    }
}

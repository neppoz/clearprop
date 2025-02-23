<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Widgets\UserBalance;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Livewire\Form;

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
//        $this->fillForms();
    }

    public function changePassword(Form $form): Form
    {
        //

        //->statePath('passwordData');
    }

    public function changeProfile(Form $form): Form
    {
        //

        //->statePath('profileData');
    }

    public function getHeaderWidgets(): array
    {
        return [
            UserBalance::class,
        ];
    }

    protected function getForms(): array
    {
        return [
            'changePassword',
            'changeProfile',
        ];
    }

}

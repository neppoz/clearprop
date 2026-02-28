<?php

use App\Filament\Pages\ManageEmail;
use App\Models\User;
use App\Settings\EmailSettings;
use Filament\Facades\Filament;
use Livewire\Livewire;

beforeEach(function () {
    $admin = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($admin);
    Filament::setCurrentPanel(Filament::getPanel('panel'));
});

it('saves smtp_port to the database when settings are saved', function () {
    Livewire::test(ManageEmail::class)
        ->fillForm([
            'smtp_host'         => 'smtp.example.com',
            'smtp_port'         => 465,
            'smtp_username'     => 'user@example.com',
            'smtp_password'     => 'secret',
            'from_address'      => 'noreply@example.com',
            'from_name'         => 'Example',
            'allow_self_signed' => false,
        ])
        ->callAction('save')
        ->assertHasNoActionErrors();

    $settings = resolve(EmailSettings::class);

    expect($settings->smtp_port)->toBe(465)
        ->and($settings->smtp_host)->toBe('smtp.example.com')
        ->and($settings->smtp_encryption)->toBe('ssl');
});

it('derives tls encryption for port 587', function () {
    Livewire::test(ManageEmail::class)
        ->fillForm([
            'smtp_host'         => 'smtp.example.com',
            'smtp_port'         => 587,
            'smtp_username'     => 'user@example.com',
            'smtp_password'     => 'secret',
            'from_address'      => 'noreply@example.com',
            'from_name'         => 'Example',
            'allow_self_signed' => false,
        ])
        ->callAction('save')
        ->assertHasNoActionErrors();

    $settings = resolve(EmailSettings::class);

    expect($settings->smtp_port)->toBe(587)
        ->and($settings->smtp_encryption)->toBe('tls');
});

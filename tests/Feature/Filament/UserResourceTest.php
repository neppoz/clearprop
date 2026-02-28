<?php

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($this->admin);
});

it('does not 500 when toggling email_verified on the create form', function () {
    Livewire::test(CreateUser::class)
        ->set('data.email_verified_at', true)
        ->assertHasNoErrors()
        ->assertStatus(200);
});

it('saves email_verified_at when toggling on on an existing user', function () {
    $user = User::factory()->create(['email_verified_at' => null]);

    Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
        ->set('data.email_verified_at', true)
        ->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

it('clears email_verified_at when toggling off on an existing user', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
        ->set('data.email_verified_at', false)
        ->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->toBeNull();
});

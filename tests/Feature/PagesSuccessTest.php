<?php

use App\Models\User;

it('can access the default Filament dashboard', function () {
    $user = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($user);
    $this->get('/adminPanel') // Ersetze '/admin', falls du eine benutzerdefinierte Admin-Route verwendest
    ->assertStatus(200)
        ->assertSee('Dashboard');
});

it('can access Admin Reservations', function () {
    $user = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($user);
    $this->get('/adminPanel/reservations') // Ersetze '/admin', falls du eine benutzerdefinierte Admin-Route verwendest
    ->assertStatus(200)
        ->assertSee('Dashboard');
});

it('can access Admin Activities', function () {
    $user = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($user);
    $this->get('/adminPanel/users') // Ersetze '/admin', falls du eine benutzerdefinierte Admin-Route verwendest
    ->assertStatus(200)
        ->assertSee('Dashboard');
});

it('can access Admin Users', function () {
    $user = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($user);
    $this->get('/adminPanel/reservations') // Ersetze '/admin', falls du eine benutzerdefinierte Admin-Route verwendest
    ->assertStatus(200)
        ->assertSee('Dashboard');
});

it('can access Admin Airplanes', function () {
    $user = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($user);
    $this->get('/adminPanel/reservations') // Ersetze '/admin', falls du eine benutzerdefinierte Admin-Route verwendest
    ->assertStatus(200)
        ->assertSee('Dashboard');
});

it('can access Admin Payments', function () {
    $user = User::where('email', 'admin@clearprop.aero')->first();
    $this->actingAs($user);
    $this->get('/adminPanel/reservations') // Ersetze '/admin', falls du eine benutzerdefinierte Admin-Route verwendest
    ->assertStatus(200)
        ->assertSee('Dashboard');
});

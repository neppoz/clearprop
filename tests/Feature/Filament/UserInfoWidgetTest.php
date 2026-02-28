<?php

use App\Filament\Widgets\App\UserInfo;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate(User::IS_ADMIN, 'web');
    Role::findOrCreate(User::IS_MEMBER, 'web');
    Role::findOrCreate(User::IS_INSTRUCTOR, 'web');
    Role::findOrCreate(User::IS_MECHANIC, 'web');
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
});

it('is visible for members', function () {
    $user = User::factory()->member()->create();
    $this->actingAs($user);

    expect(UserInfo::canView())->toBeTrue();
});

it('is visible for instructors', function () {
    $user = User::factory()->instructor()->create([
        'email' => 'instructor_widget_test@example.com',
    ]);
    $this->actingAs($user);

    expect(UserInfo::canView())->toBeTrue();
});

it('is visible for mechanics', function () {
    $user = User::factory()->mechanic()->create();
    $this->actingAs($user);

    expect(UserInfo::canView())->toBeTrue();
});

it('is not visible for admins without other roles', function () {
    $user = User::factory()->admin()->create([
        'email' => 'admin_widget_test@example.com',
    ]);
    $this->actingAs($user);

    expect(UserInfo::canView())->toBeFalse();
});

it('is not visible for guests', function () {
    expect(UserInfo::canView())->toBeFalse();
});

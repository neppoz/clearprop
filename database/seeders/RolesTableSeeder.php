<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::findOrCreate(User::IS_ADMIN, 'web');
        Role::findOrCreate(User::IS_MEMBER, 'web');
        Role::findOrCreate(User::IS_MANAGER, 'web');
        Role::findOrCreate(User::IS_INSTRUCTOR, 'web');
        Role::findOrCreate(User::IS_MECHANIC, 'web');

    }
}

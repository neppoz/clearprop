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

        Role::findOrCreate('Admin', User::IS_ADMIN);
        Role::findOrCreate('Member', User::IS_MEMBER);
        Role::findOrCreate('Manager', User::IS_MANAGER);
        Role::findOrCreate('Instructor', User::IS_INSTRUCTOR);
        Role::findOrCreate('Mechanic', User::IS_MECHANIC);

    }
}

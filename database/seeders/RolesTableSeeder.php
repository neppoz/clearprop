<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::findOrCreate('Admin', 'Admin');
        Role::findOrCreate('Member', 'Admin');
        Role::findOrCreate('Manager', 'Admin');
        Role::findOrCreate('Instructor', 'Admin');
        Role::findOrCreate('Mechanic', 'Admin');

    }
}

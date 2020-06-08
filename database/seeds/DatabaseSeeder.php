<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            FactorTableSeeder::class,
            TypeTableSeeder::class,
            FactorTypeTableSeeder::class,
            IncomeCategoriesTableSeeder::class,
            ExpenseCategoriesTableSeeder::class,
            PlaneTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
        ]);
    }
}

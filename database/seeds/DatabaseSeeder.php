<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,

            FactorTableSeeder::class,
            TypeTableSeeder::class,
            FactorTypeTableSeeder::class,
            IncomeCategoriesTableSeeder::class,
            ExpenseCategoriesTableSeeder::class,
            PlaneTableSeeder::class,
        ]);
    }
}

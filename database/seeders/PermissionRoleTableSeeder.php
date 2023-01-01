<?php

namespace Database\Seeders;

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $all_permissions = Permission::all();
        Role::findOrFail(\App\User::IS_ADMIN)->permissions()->sync($all_permissions->pluck('id'));

        $manager_permissions = [1, 35, 37, 39, 40, 41, 42, 43, 83, 84, 85, 86, 87, 88, 89, 108, 112, 115, 116, 117, 118, 119, 120, 125, 126, 127, 128, 130, 133];
        Role::findOrFail(\App\User::IS_MANAGER)->permissions()->syncWithoutDetaching($manager_permissions);

        $user_permissions = [35, 37, 39, 40, 41, 42, 43, 83, 84, 85, 86, 87, 88, 89, 117, 121, 128, 133];
        Role::findOrFail(\App\User::IS_MEMBER)->permissions()->syncWithoutDetaching($user_permissions);

        $instructor_permissions = [35, 37, 39, 40, 41, 42, 43, 83, 84, 85, 86, 87, 88, 89, 108, 112, 117, 118, 119, 120, 121, 122, 123, 124, 128, 129, 132, 133];
        Role::findOrFail(\App\User::IS_INSTRUCTOR)->permissions()->syncWithoutDetaching($instructor_permissions);

        $mechanic_permissions = [35, 37, 39, 40, 41, 42, 43, 83, 84, 85, 86, 87, 88, 89, 108, 117, 119, 123, 128, 133];
        Role::findOrFail(\App\User::IS_MECHANIC)->permissions()->syncWithoutDetaching($mechanic_permissions);
    }
}

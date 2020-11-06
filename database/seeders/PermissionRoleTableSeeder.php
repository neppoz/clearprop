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

        $manager_permissions = [35, 37, 39, 40, 41, 42, 43, 83, 84, 85, 86, 87, 88, 89];
        Role::findOrFail(\App\User::IS_MANAGER)->permissions()->syncWithoutDetaching($manager_permissions);

        $user_permissions = [35, 37, 39, 40, 41, 42, 43, 83, 84, 85, 86, 87, 88, 89];
        Role::findOrFail(\App\User::IS_MEMBER)->permissions()->syncWithoutDetaching($user_permissions);
    }
}

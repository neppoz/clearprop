<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            [
                'id' => '83',
                'title' => 'profile_password_edit',
            ],
            [
                'id' => '84',
                'title' => 'profile_data_edit',
            ],
        ];
        Permission::insertOrIgnore($permissions);

        Role::findOrFail(App\User::IS_ADMIN)->permissions()->syncWithoutDetaching(Arr::pluck($permissions, 'id'));
        Role::findOrFail(App\User::IS_MANAGER)->permissions()->syncWithoutDetaching(Arr::pluck($permissions, 'id'));
        Role::findOrFail(App\User::IS_MEMBER)->permissions()->syncWithoutDetaching(Arr::pluck($permissions, 'id'));
    }

}

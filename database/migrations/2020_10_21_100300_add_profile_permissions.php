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
        artisan::call('db:seed', array(
            '--class' => 'PermissionsTableSeeder'
        ));
        artisan::call('db:seed', array(
            '--class' => 'RolesTableSeeder'
        ));
        artisan::call('db:seed', array(
            '--class' => 'PermissionRoleTableSeeder'
        ));
    }

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;
use App\Role;
use App\User;

class CreateSlotsTable extends Migration
{
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::disableForeignKeyConstraints();

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('type_fk_bookings');
            $table->dropColumn('type_id');
        });

        Schema::enableForeignKeyConstraints();

        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('slot_id')->after('user_id')->nullable();
            $table->foreign('slot_id', 'slot_fk_bookings')->references('id')->on('slots');
        });

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

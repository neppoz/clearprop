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

        $permissions = [
            [
                'id' => '77',
                'title' => 'slot_create',
            ],
            [
                'id' => '78',
                'title' => 'slot_edit',
            ],
            [
                'id' => '79',
                'title' => 'slot_show',
            ],
            [
                'id' => '80',
                'title' => 'slot_delete',
            ],
            [
                'id' => '81',
                'title' => 'slot_access',
            ],
            [
                'id' => '82',
                'title' => 'schedule_access',
            ],
        ];
        Permission::insertOrIgnore($permissions);

        Role::findOrFail(App\User::IS_ADMIN)->permissions()->syncWithoutDetaching(Arr::pluck($permissions, 'id'));
//        Role::findOrFail(App\User::IS_MANAGER)->permissions()->syncWithoutDetaching(Arr::pluck($permissions, 'id'));
//        Role::findOrFail(App\User::IS_MEMBER)->permissions()->syncWithoutDetaching(Arr::pluck($permissions, 'id'));

    }
}

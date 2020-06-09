<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::create('users', function (Blueprint $table) {
                $table->string('taxno')->after('lang')->nullable();
                $table->string('phone_1')->after('taxno')->nullable();
                $table->string('phone_2')->after('phone_1')->nullable();
                $table->string('address')->after('phone_2')->nullable();
                $table->string('city')->after('address')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('taxno');
            $table->dropColumn('phone_1');
            $table->dropColumn('phone_2');
            $table->dropColumn('address');
            $table->dropColumn('city');
        });
    }
}

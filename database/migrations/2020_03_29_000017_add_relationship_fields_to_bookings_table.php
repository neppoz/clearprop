<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1172722')->references('id')->on('users');
            $table->unsignedInteger('plane_id');
            $table->foreign('plane_id', 'plane_fk_1172723')->references('id')->on('planes');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_1223686')->references('id')->on('users');
        });

    }
}

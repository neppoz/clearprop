<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToActivitiesTable extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1169385')->references('id')->on('users');
            $table->unsignedInteger('plane_id');
            $table->foreign('plane_id', 'plane_fk_1169386')->references('id')->on('planes');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id', 'type_fk_1169396')->references('id')->on('types');
            $table->unsignedInteger('copilot_id')->nullable();
            $table->foreign('copilot_id', 'copilot_fk_1223683')->references('id')->on('users');
            $table->unsignedInteger('instructor_id')->nullable();
            $table->foreign('instructor_id', 'instructor_fk_1223684')->references('id')->on('users');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_1223685')->references('id')->on('users');
        });
    }

    public function down()
    {
        //
    }
}

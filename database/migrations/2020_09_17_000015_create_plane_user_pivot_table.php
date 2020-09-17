<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaneUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('plane_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2200347')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('plane_id');
            $table->foreign('plane_id', 'plane_id_fk_2200347')->references('id')->on('planes')->onDelete('cascade');
        });
    }
}

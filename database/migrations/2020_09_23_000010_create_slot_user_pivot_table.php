<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('slot_user', function (Blueprint $table) {
            $table->unsignedInteger('slot_id');
            $table->foreign('slot_id', 'slot_id_fk_2250338')->references('id')->on('slots')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2250338')->references('id')->on('users')->onDelete('cascade');
        });
    }
}

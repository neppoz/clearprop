<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number')->nullable();
            $table->string('name')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('start_hours')->nullable();
            $table->date('start_date')->nullable();
            $table->integer('end_hours')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('current_running_hours')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

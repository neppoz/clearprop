<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->time('event_start')->nullable();
            $table->time('event_stop')->nullable();
            $table->boolean('engine_warmup')->default(0)->nullable();
            $table->float('warmup_start', 15, 2)->nullable();
            $table->float('counter_start', 15, 2);
            $table->float('counter_stop', 15, 2);
            $table->integer('warmup_minutes')->nullable();
            $table->float('rate', 15, 2)->nullable();
            $table->integer('minutes')->nullable();
            $table->float('amount', 15, 2)->nullable();
            $table->string('departure')->nullable();
            $table->string('arrival')->nullable();
            $table->date('event');
            $table->timestamps();
            $table->softDeletes();
        });

    }
}

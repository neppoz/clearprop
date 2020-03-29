<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('reservation_start');
            $table->datetime('reservation_stop');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}

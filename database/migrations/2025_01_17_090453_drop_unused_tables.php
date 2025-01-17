<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUnusedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('slot_fk_bookings');
        });

        Schema::dropIfExists('webhook_calls');
        Schema::dropIfExists('parameters');
        Schema::dropIfExists('slot_user');
        Schema::dropIfExists('slots');
    }

}

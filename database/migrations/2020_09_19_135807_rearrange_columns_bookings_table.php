<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RearrangeColumnsBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('type_fk_bookings');
            $table->renameColumn('type_id', 'instructor_needed');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('modus')->after('description')->default(0);
            $table->unsignedInteger('type_id')->after('user_id')->nullable();
            $table->foreign('type_id', 'type_fk_bookings')->references('id')->on('types');
        });
    }

}

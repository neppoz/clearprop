<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mode;

class CreateBookingModesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        artisan::call('db:seed', array(
            '--class' => 'ModesTableSeeder'
        ));

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('modus');
            $table->unsignedInteger('mode_id')->after('deleted_at');
            $table->foreign('mode_id')->references('id')->on('modes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modes');
    }
}

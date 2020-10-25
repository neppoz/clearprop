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
        Schema::disableForeignKeyConstraints();

        Schema::create('modes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        artisan::call('db:seed', array(
            '--class' => 'ModesTableSeeder'
        ));

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('modus');
            $table->unsignedInteger('mode_id')->after('description')->default(1);
            $table->foreign('mode_id')->references('id')->on('modes')->onDelete('cascade');
            $table->boolean('checkin')->nullable()->after('slot_id');
            $table->unsignedInteger('seats')->nullable()->after('checkin');
        });

        Schema::enableForeignKeyConstraints();

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPlanePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plane_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('plane_id');
            $table->decimal('base_price_per_minute', 10, 2);
            $table->timestamps();
            $table->softDeletes(); // Optional: Soft Delete Feld
        });

        Schema::table('user_plane_prices', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('plane_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_plane_prices');
    }
}

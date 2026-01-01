<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop location_id from assets table
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        // Drop location_id from assets_histories table
        Schema::table('assets_histories', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        // Drop the asset_locations table
        Schema::dropIfExists('asset_locations');
    }

    public function down(): void
    {
        // Recreate asset_locations table
        Schema::create('asset_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Add location_id back to assets
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable()->after('status');
            $table->foreign('location_id')->references('id')->on('asset_locations');
        });

        // Add location_id back to assets_histories
        Schema::table('assets_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable()->after('status');
            $table->foreign('location_id')->references('id')->on('asset_locations');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convert status_id to status enum string in assets table
        Schema::table('assets', function (Blueprint $table) {
            $table->string('status')->nullable()->after('status_id');
        });

        // Map old status_id values to new enum values
        DB::table('assets')->where('status_id', 1)->update(['status' => 'active']);
        DB::table('assets')->where('status_id', 2)->update(['status' => 'inactive']);
        DB::table('assets')->where('status_id', 3)->update(['status' => 'broken']);
        DB::table('assets')->where('status_id', 4)->update(['status' => 'out_for_repair']);

        // Drop the old status_id column and foreign key
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });

        // Convert status_id to status in assets_histories table
        Schema::table('assets_histories', function (Blueprint $table) {
            $table->string('status')->nullable()->after('status_id');
        });

        // Map old status_id values to new enum values
        DB::table('assets_histories')->where('status_id', 1)->update(['status' => 'active']);
        DB::table('assets_histories')->where('status_id', 2)->update(['status' => 'inactive']);
        DB::table('assets_histories')->where('status_id', 3)->update(['status' => 'broken']);
        DB::table('assets_histories')->where('status_id', 4)->update(['status' => 'out_for_repair']);

        // Drop the old status_id column and foreign key
        Schema::table('assets_histories', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });

        // Drop the asset_statuses table
        Schema::dropIfExists('asset_statuses');
    }

    public function down(): void
    {
        // Recreate asset_statuses table
        Schema::create('asset_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Seed the statuses
        DB::table('asset_statuses')->insert([
            ['id' => 1, 'name' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Inactive', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Broken', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Out for Repair', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Add status_id back to assets
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable()->after('current_running_hours');
            $table->foreign('status_id')->references('id')->on('asset_statuses');
        });

        // Map enum values back to status_id
        DB::table('assets')->where('status', 'active')->update(['status_id' => 1]);
        DB::table('assets')->where('status', 'inactive')->update(['status_id' => 2]);
        DB::table('assets')->where('status', 'broken')->update(['status_id' => 3]);
        DB::table('assets')->where('status', 'out_for_repair')->update(['status_id' => 4]);

        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Add status_id back to assets_histories
        Schema::table('assets_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable()->after('asset_id');
            $table->foreign('status_id')->references('id')->on('asset_statuses');
        });

        // Map enum values back to status_id
        DB::table('assets_histories')->where('status', 'active')->update(['status_id' => 1]);
        DB::table('assets_histories')->where('status', 'inactive')->update(['status_id' => 2]);
        DB::table('assets_histories')->where('status', 'broken')->update(['status_id' => 3]);
        DB::table('assets_histories')->where('status', 'out_for_repair')->update(['status_id' => 4]);

        Schema::table('assets_histories', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

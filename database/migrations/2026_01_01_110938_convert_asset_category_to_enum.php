<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add category column to assets table
        Schema::table('assets', function (Blueprint $table) {
            $table->string('category')->nullable()->after('category_id');
        });

        // Map old category_id values to new enum values
        // 1 = Elica → propeller, 2 = Motore → engine, 3 = Cellula → airframe, 4 = Avanzato → advanced
        DB::table('assets')->where('category_id', 1)->update(['category' => 'propeller']);
        DB::table('assets')->where('category_id', 2)->update(['category' => 'engine']);
        DB::table('assets')->where('category_id', 3)->update(['category' => 'airframe']);
        DB::table('assets')->where('category_id', 4)->update(['category' => 'advanced']);

        // Drop the old category_id column and foreign key
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        // Drop the asset_categories table
        Schema::dropIfExists('asset_categories');
    }

    public function down(): void
    {
        // Recreate asset_categories table
        Schema::create('asset_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Seed the categories
        DB::table('asset_categories')->insert([
            ['id' => 1, 'name' => 'Elica', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Motore', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Cellula', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Avanzato', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Add category_id back to assets
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            $table->foreign('category_id')->references('id')->on('asset_categories');
        });

        // Map enum values back to category_id
        DB::table('assets')->where('category', 'propeller')->update(['category_id' => 1]);
        DB::table('assets')->where('category', 'engine')->update(['category_id' => 2]);
        DB::table('assets')->where('category', 'airframe')->update(['category_id' => 3]);
        DB::table('assets')->where('category', 'advanced')->update(['category_id' => 4]);

        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveObsoleteColumnsFromActivitiesTable extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['rate', 'engine_warmup']);
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->decimal('rate', 10, 2)->nullable(); // Re-add rate if rolled back
            $table->boolean('engine_warmup')->default(false); // Re-add engine_warmup if rolled back
        });
    }
}

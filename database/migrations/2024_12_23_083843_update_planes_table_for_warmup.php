<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlanesTableForWarmup extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            if (Schema::hasColumn('planes', 'warmup_type')) {
                $table->dropColumn('warmup_type');
            }

            $table->integer('warmup_minutes')->default(0)->after('counter_type');
            $table->boolean('pilot_paying_warmup')->default(false)->after('warmup_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            // Re-add warmup_type column
            $table->string('warmup_type')->nullable()->after('counter_type');

            $table->dropColumn('warmup_minutes');
            $table->dropColumn('pilot_paying_warmup');
        });
    }
}

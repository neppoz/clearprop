<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->decimal('instructor_price_per_minute', 10, 2)->after('rate')->nullable()->default(0);
            $table->double('rate', 15, 2)->nullable()->default(0)->change();
            $table->double('counter_start', 15, 2)->nullable()->default(0)->change();
            $table->double('counter_stop', 15, 2)->nullable()->default(0)->change();
            $table->double('warmup_start', 15, 2)->nullable()->default(0)->change();
            $table->double('amount', 15, 2)->nullable()->default(0)->change();
            $table->integer('minutes')->nullable()->default(0)->change();
            $table->integer('warmup_minutes')->nullable()->default(0)->change();

            $table->index('minutes');
            $table->index('amount');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('activities', [instructor_price_per_minute]);
    }
};

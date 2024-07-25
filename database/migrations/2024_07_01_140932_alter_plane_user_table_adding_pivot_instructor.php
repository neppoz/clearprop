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
        Schema::table('plane_user', function (Blueprint $table) {
            $table->decimal('instructor_price_per_minute', 10, 2)->after('base_price_per_minute')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('plane_user', [instructor_price_per_minute]);
    }
};
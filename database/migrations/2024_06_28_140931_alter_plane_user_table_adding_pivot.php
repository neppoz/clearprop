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
            $table->decimal('base_price_per_user', 10, 2)->default(0);
            $table->enum('rating_status', ['student', 'review', 'rated'])->default('review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('plane_user', [instructor_price_per_minute, rating_status]);
    }
};

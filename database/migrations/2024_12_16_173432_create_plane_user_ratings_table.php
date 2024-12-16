<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plane_user_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('plane_id');
            $table->string('status'); // Enum field for RatingStatus
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plane_id')->references('id')->on('planes')->onDelete('cascade');

            // Unique constraint to prevent duplicate entries
            $table->unique(['user_id', 'plane_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plane_user_ratings');
        Schema::dropColumns('plane_user', 'rating_status');
    }

};

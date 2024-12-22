<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the package
            $table->unsignedInteger('user_id'); // Associated user
            $table->decimal('price', 10, 2); // Package price
            $table->decimal('hours', 5, 2); // Maximum hours in the package
            $table->date('valid_from'); // Start date of validity
            $table->date('valid_until'); // End date of validity
            $table->string('type'); // Package type (hourly, fixed)
            $table->unsignedInteger('plane_id')->nullable(); // Optional: Restrict to a specific plane
            $table->unsignedInteger('instructor_id')->nullable(); // Optional: Restrict to a specific instructor
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plane_id')->references('id')->on('planes')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
}

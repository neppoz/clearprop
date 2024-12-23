<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePackagesTableReplaceInstructorId extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign('packages_instructor_id_foreign');
            $table->dropColumn('instructor_id'); // Drop the old column
            $table->boolean('instructor_included')->default(false); // Add the new column
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('instructor_included'); // Remove the new column
            $table->unsignedBigInteger('instructor_id')->nullable(); // Restore the old column
        });
    }
}

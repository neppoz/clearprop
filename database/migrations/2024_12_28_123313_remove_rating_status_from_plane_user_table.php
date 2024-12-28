<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveRatingStatusFromPlaneUserTable extends Migration
{
    public function up(): void
    {
        Schema::table('plane_user', function (Blueprint $table) {
            if (Schema::hasColumn('plane_user', 'rating_status')) {
                $table->dropColumn('rating_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('plane_user', function (Blueprint $table) {
            if (!Schema::hasColumn('plane_user', 'rating_status')) {
                $table->string('rating_status')->nullable(); // Rückgängig machen
            }
        });
    }
}

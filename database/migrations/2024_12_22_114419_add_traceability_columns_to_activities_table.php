<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTraceabilityColumnsToActivitiesTable extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->decimal('base_price_per_minute', 10, 2)->nullable(); // Applied base price
            $table->decimal('instructor_price_per_minute', 10, 2)->nullable(); // Applied instructor price
            $table->unsignedBigInteger('package_id')->nullable(); // Referenced package
            $table->integer('remaining_package_minutes')->nullable(); // Remaining minutes in the package
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'base_price_per_minute',
                'instructor_price_per_minute',
                'package_id',
                'package_price',
                'remaining_package_minutes',
            ]);
        });
    }
}

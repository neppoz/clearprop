<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->integer('service_interval_hours')->nullable()->after('current_running_hours');
            $table->integer('last_service_hours')->nullable()->after('service_interval_hours');
            $table->date('last_service_date')->nullable()->after('last_service_hours');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['service_interval_hours', 'last_service_hours', 'last_service_date']);
        });
    }
};

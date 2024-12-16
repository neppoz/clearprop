<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->decimal('instructor_price_per_minute', 8, 2)->default(0)->after('default_price_per_minute');
        });
    }

    public function down(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->dropColumn('instructor_price_per_minute');
        });
    }

};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('assets_histories');
    }

    public function down(): void
    {
        Schema::create('assets_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets');
            $table->string('status')->nullable();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users');
            $table->foreignId('plane_id')->nullable()->constrained('planes');
            $table->timestamps();
        });
    }
};

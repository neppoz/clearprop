<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAssetsTable extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('asset_categories');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('asset_statuses');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('asset_locations');
            $table->unsignedInteger('assigned_to_id')->nullable();
            $table->foreign('assigned_to_id')->references('id')->on('users');
            $table->unsignedInteger('plane_id')->nullable();
            $table->foreign('plane_id')->references('id')->on('planes');
        });
    }
}

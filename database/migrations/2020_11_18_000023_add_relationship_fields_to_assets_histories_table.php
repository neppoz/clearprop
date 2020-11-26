<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAssetsHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('assets_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('asset_statuses');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('asset_locations');
            $table->unsignedInteger('assigned_user_id')->nullable();
            $table->foreign('assigned_user_id')->references('id')->on('users');
            $table->unsignedInteger('plane_id')->nullable();
            $table->foreign('plane_id')->references('id')->on('planes');
        });

        artisan::call('db:seed', array(
            '--class' => 'AssetStatusTableSeeder'
        ));

        artisan::call('db:seed', array(
            '--class' => 'PermissionsTableSeeder'
        ));

        artisan::call('db:seed', array(
            '--class' => 'PermissionRoleTableSeeder'
        ));
    }

}

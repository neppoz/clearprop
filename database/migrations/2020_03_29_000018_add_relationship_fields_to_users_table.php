<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('factor_id')->nullable();
            $table->foreign('factor_id', 'factor_fk_1168765')->references('id')->on('factors');
        });
    }

    public function down()
    {
        //
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToIncomesTable extends Migration
{
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->unsignedInteger('income_category_id')->nullable();
            $table->foreign('income_category_id', 'income_category_fk_1223676')->references('id')->on('income_categories');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_1223711')->references('id')->on('users');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_1223712')->references('id')->on('users');
        });
    }

    public function down()
    {
        //
    }
}

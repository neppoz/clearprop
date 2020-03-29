<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('income_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('deposit')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}

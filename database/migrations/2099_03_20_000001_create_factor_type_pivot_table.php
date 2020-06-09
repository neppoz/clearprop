<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorTypePivotTable extends Migration
{
    public function up()
    {
        Schema::create('factor_type', function (Blueprint $table) {
            $table->unsignedInteger('factor_id');
            $table->foreign('factor_id', 'factor_id_fk_1169147')->references('id')->on('factors')->onDelete('cascade');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id', 'type_id_fk_1169147')->references('id')->on('types')->onDelete('cascade');
        });
    }

    public function down()
    {
        //
    }
}

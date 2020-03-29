<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPivotTable extends Migration
{
    public function up()
    {
        Schema::table('factor_type', function (Blueprint $table) {
            $table->float('rate', 15, 2)->after('type_id');
            $table->longText('description')->after('rate')->nullable();
        });
    }
}

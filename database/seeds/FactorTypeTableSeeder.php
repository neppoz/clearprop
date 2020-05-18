<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FactorTypeTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        DB::table('factor_type')->insert([
            'factor_id' => '1',
            'type_id' => '1',
            'rate' => '1.10',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '1',
            'type_id' => '2',
            'rate' => '1.10',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '1',
            'type_id' => '3',
            'rate' => '1.80',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '1',
            'type_id' => '4',
            'rate' => '0.00',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '1',
            'type_id' => '5',
            'rate' => '1.80',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);



        DB::table('factor_type')->insert([
            'factor_id' => '2',
            'type_id' => '1',
            'rate' => '1.50',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '2',
            'type_id' => '2',
            'rate' => '1.50',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '2',
            'type_id' => '3',
            'rate' => '0.00',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '2',
            'type_id' => '4',
            'rate' => '0.00',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factor_type')->insert([
            'factor_id' => '2',
            'type_id' => '5',
            'rate' => '1.80',
//            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IncomeCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        DB::table('income_categories')->insert([
            'id' => '1',
            'name' => 'Activity deposit',
            'deposit' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('income_categories')->insert([
            'id' => '2',
            'name' => 'Hangar fee',
            'deposit' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('income_categories')->insert([
            'id' => '3',
            'name' => 'Other services',
            'deposit' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('income_categories')->insert([
            'id' => '4',
            'name' => 'Balance 2020',
            'deposit' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('income_categories')->insert([
            'id' => '5',
            'name' => 'Membership fee',
            'deposit' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

    }
}

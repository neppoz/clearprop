<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        ]);
        DB::table('income_categories')->insert([
            'id' => '2',
            'name' => 'Hangar fee',
            'deposit' => '0',
        ]);
        DB::table('income_categories')->insert([
            'id' => '3',
            'name' => 'Maintenance',
            'deposit' => '0',
        ]);
        DB::table('income_categories')->insert([
            'id' => '4',
            'name' => 'Saldo inizio anno 2020',
            'deposit' => '0',
        ]);
    }
}

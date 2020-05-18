<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        DB::table('expense_categories')->insert([
            'id' => '1',
            'name' => 'Rent',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '2',
            'name' => 'Insurance',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '3',
            'name' => 'Plane maintenance',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '4',
            'name' => 'Runway maintenance',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '5',
            'name' => 'Hangar maintenance',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '6',
            'name' => 'Fuel',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '7',
            'name' => 'Office supplies',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '8',
            'name' => 'Miscellaneous',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('expense_categories')->insert([
            'id' => '9',
            'name' => 'Extraordinary expenses',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

    }
}

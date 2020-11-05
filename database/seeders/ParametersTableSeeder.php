<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Parameter;

class ParametersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parameter::firstOrCreate(
            ['id' => '100'],
            [
                'id' => '100',
                'slug' => 'check.medical',
                'value' => '1',
                'lang' => 'ALL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        Parameter::firstOrCreate(
            ['id' => '101'],
            [
                'id' => '101',
                'slug' => 'check.balance',
                'value' => '1',
                'lang' => 'ALL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        Parameter::firstOrCreate(
            ['id' => '102'],
            [
                'id' => '102',
                'slug' => 'check.activities',
                'value' => '1',
                'lang' => 'ALL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        Parameter::firstOrCreate(
            ['id' => '103'],
            [
                'id' => '103',
                'slug' => 'check.balance.limit.amount',
                'value' => '-200',
                'lang' => 'ALL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        Parameter::firstOrCreate(
            ['id' => '104'],
            [
                'id' => '104',
                'slug' => 'check.activities.limit.days',
                'value' => '90',
                'lang' => 'ALL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        // Parameter::firstOrCreate(
        //     ['id' => '105'],
        //     [
        //         'id' => '105',
        //         'slug' => 'check.activities.limit.hours',
        //         'value' => '0',
        //         'lang' => 'ALL',
        //         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        //     ]
        // );
    }
}

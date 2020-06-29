<?php

use App\Plane;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class UserTableSeeder.
 */
class PlaneTableSeeder extends Seeder
{

    /**
     * Run the database seed.
     */
    public function run()
    {
        Plane::create([
            'callsign' => 'I-C001',
            'vendor' => 'ICP',
            'model' => 'Savannah S',
            'counter_type' => '100',
            'active' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        Plane::create([
            'callsign' => 'I-A918',
            'vendor' => 'Tecnam',
            'model' => 'P92 Eaglet',
            'counter_type' => '100',
            'active' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

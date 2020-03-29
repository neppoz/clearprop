<?php

use App\Plane;
use Illuminate\Database\Seeder;

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
            'active' => '1',
        ]);
        Plane::create([
            'callsign' => 'I-A918',
            'vendor' => 'Tecnam',
            'model' => 'P92 Eaglet',
            'active' => '1',
        ]);
    }
}

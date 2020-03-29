<?php

use App\Factor;
use Illuminate\Database\Seeder;

/**
 * Class UserStateTableSeeder.
 */
class FactorTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        Factor::create([
            'id'          => '1',
            'name'          => 'Premium',
        ]);

        Factor::create([
            'id'          => '2',
            'name'          => 'Standard',
        ]);
    }
}

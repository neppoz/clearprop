<?php
namespace Database\Seeders;

use App\Factor;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        Factor::create([
            'id'          => '2',
            'name'          => 'Standard',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

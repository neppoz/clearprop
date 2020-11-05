<?php
namespace Database\Seeders;

use App\Type;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class UserTableSeeder.
 */
class TypeTableSeeder extends Seeder
{

    /**
     * Run the database seed.
     */
    public function run()
    {
        Type::create([
            'id' => '1',
            'name' => 'Volo locale',
            'active' => '1',
            'instructor' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        Type::create([
            'id' => '2',
            'name' => 'Volo trasferta',
            'active' => '1',
            'instructor' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        Type::create([
            'id' => '3',
            'name' => 'Volo per il club',
            'active' => '1',
            'instructor' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        Type::create([
            'id' => '4',
            'name' => 'Manutenzione',
            'active' => '1',
            'instructor' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        Type::create([
            'id' => '5',
            'name' => 'Volo locale con istruttore',
            'active' => '1',
            'instructor' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        Type::create([
            'id' => '6',
            'name' => 'Volo trasferta con istruttore',
            'active' => '1',
            'instructor' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

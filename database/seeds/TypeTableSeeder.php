<?php

use App\Type;
use Illuminate\Database\Seeder;

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
        ]);
        Type::create([
            'id' => '2',
            'name' => 'Volo trasferta',
            'active' => '1',
            'instructor' => '0',
        ]);
        Type::create([
            'id' => '3',
            'name' => 'Volo locale con istruttore',
            'active' => '1',
            'instructor' => '1',
        ]);
        Type::create([
            'id' => '4',
            'name' => 'Manutenzione',
            'active' => '1',
            'instructor' => '0',
        ]);
        Type::create([
            'id' => '5',
            'name' => 'Volo trasferta con istruttore',
            'active' => '1',
            'instructor' => '1',
        ]);
    }
}

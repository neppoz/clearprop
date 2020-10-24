<?php

use App\Mode;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class ModesTableSeeder.
 */
class ModesTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        $modes = [
            [
                'id' => '1',
                'name' => 'Charter',
                'active' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => '2',
                'name' => 'School',
                'active' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => '3',
                'name' => 'Promotion',
                'active' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => '4',
                'name' => 'Maintenance',
                'active' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        Mode::insertOrIgnore($modes);

//        $item = new Mode();
//        $translations = [
//            'en' => 'Promotion',
//            'it' => 'Promozione'
//        ];
//        $item->setTranslations('name', $translations);

    }
}

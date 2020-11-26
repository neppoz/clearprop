<?php

namespace Database\Seeders;

use App\AssetStatus;
use Illuminate\Database\Seeder;

class AssetStatusTableSeeder extends Seeder
{
    public function run()
    {
        $assetStatuses = [
            [
                'id' => 1,
                'name' => 'Active',
                'created_at' => '2020-11-18 07:35:03',
                'updated_at' => '2020-11-18 07:35:03',
            ],
            [
                'id' => 2,
                'name' => 'Inactive',
                'created_at' => '2020-11-18 07:35:03',
                'updated_at' => '2020-11-18 07:35:03',
            ],
            [
                'id' => 3,
                'name' => 'Broken',
                'created_at' => '2020-11-18 07:35:03',
                'updated_at' => '2020-11-18 07:35:03',
            ],
            [
                'id' => 4,
                'name' => 'Out for Repair',
                'created_at' => '2020-11-18 07:35:03',
                'updated_at' => '2020-11-18 07:35:03',
            ],
        ];

        AssetStatus::insertorIgnore($assetStatuses);
    }
}

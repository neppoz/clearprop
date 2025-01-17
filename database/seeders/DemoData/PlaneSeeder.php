<?php

namespace Database\Seeders\DemoData;

use App\Models\Activity;
use App\Models\Plane;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlaneSeeder extends Seeder
{
    public function run(): void
    {
        Plane::factory()->count(3)->create();

    }
}

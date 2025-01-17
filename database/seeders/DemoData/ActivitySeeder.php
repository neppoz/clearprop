<?php

namespace Database\Seeders\DemoData;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::factory()->count(32)->create();

    }
}

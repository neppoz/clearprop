<?php

namespace Database\Seeders\DemoData;

use App\Models\Activity;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::factory()->count(32)->create();

    }
}

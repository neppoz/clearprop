<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Call the UserSeeder from the DemoData namespace
        $this->call(\Database\Seeders\DemoData\UserSeeder::class);

        // Call the PlaneSeeder from the DemoData namespace
        $this->call(\Database\Seeders\DemoData\PlaneSeeder::class);

        // Call the ReservationSeeder from the DemoData namespace
        $this->call(\Database\Seeders\DemoData\ReservationSeeder::class);

        // Call the ActivitySeeder from the DemoData namespace
        $this->call(\Database\Seeders\DemoData\ActivitySeeder::class);
    }
}

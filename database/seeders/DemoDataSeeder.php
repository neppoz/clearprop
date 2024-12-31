<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Call the UserSeeder from the DemoData namespace
        $this->call(\Database\Seeders\DemoData\UserSeeder::class);
    }
}

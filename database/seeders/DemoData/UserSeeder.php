<?php

namespace Database\Seeders\DemoData;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create one instructor
        User::factory()->instructor()->create();

        // Create 50 members
        User::factory()->member()->count(50)->create();
    }
}

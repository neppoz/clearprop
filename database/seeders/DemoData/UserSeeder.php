<?php

namespace Database\Seeders\DemoData;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create one admin
        User::factory()->admin()->create();

        // Create one instructor
        User::factory()->instructor()->create();

        // Create 100 members
        User::factory()->count(100)->create();
    }
}

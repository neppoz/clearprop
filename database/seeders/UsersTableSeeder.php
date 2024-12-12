<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@clearprop.aero',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('boldpilot'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ];

        \App\Models\User::insertOrIgnore($users);
    }
}

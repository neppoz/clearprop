<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@clearprop.aero',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('BoldPilot'),
                'remember_token' => null,
                'lang' => 'EN',
                'factor_id' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ];

        User::insert($users);
    }
}

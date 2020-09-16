<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Super Admin',
                'email'          => 'support@clearprop.aero',
                'password'       => Hash::make('BoldPilot'),
                'remember_token' => null,
                'lang'           => 'EN',
                'factor_id'      => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ];

        User::insert($users);
    }
}

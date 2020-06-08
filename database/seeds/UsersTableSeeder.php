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
                'email'          => 'neppoz.com@gmail.com',
                'password'       => '$2y$10$XzjqHC9sHvOgxSN9Xk7A7.KSmh/PUZztf/MOqZUgDGT5rB5vYQ/9C',
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

<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$C0aSFjmijAvJs43eV8fGOu8BglbJNsbJ4zxPhrdAxUA8sfjv.faLC',
                'remember_token' => null,
                'license'        => '',
            ],
        ];

        User::insert($users);

    }
}

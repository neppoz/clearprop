<?php

use App\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->roles()->sync(1);

        $members = User::where('id', '>', 1)->get();
        foreach ($members as $member) {
            $member->roles()->sync(2);
        }
    }
}

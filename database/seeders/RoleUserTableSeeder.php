<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->roles()->sync(User::IS_ADMIN);

        $members = User::where('id', '>', 1)->get();
        foreach ($members as $member) {
            $member->roles()->sync(User::IS_MEMBER);
        }
    }
}

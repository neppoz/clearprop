<?php
namespace Database\Seeders;

use App\Role;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(
            ['id' => '1'],
            [
                'id' => '1',
                'title' => 'Admin'
            ]
        );

        Role::updateOrCreate(
            ['id' => '2'],
            [
                'id' => '2',
                'title' => 'Member'
            ]
        );

        Role::updateOrCreate(
            ['id' => '3'],
            [
                'id' => '3',
                'title' => 'Manager'
            ]
        );

        Role::updateOrCreate(
            ['id' => '4'],
            [
                'id' => '4',
                'title' => 'Instructor'
            ]
        );

        Role::updateOrCreate(
            ['id' => '5'],
            [
                'id' => '5',
                'title' => 'Mechanic'
            ]
        );

    }
}

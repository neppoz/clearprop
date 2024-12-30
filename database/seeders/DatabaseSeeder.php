<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            ModesTableSeeder::class,
            IncomeCategorySeeder::class,
        ]);
    }
}

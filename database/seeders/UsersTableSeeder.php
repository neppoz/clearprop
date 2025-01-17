<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // User interaction
        $name = $this->command->ask('Enter the admin name', 'Super Admin');
        $email = $this->command->ask('Enter the admin email', 'admin@clearprop.aero');
        $password = $this->command->secret('Enter the admin password (hidden input)');

        // Make sure the password is set
        if (!$password) {
            $this->command->error('Password cannot be empty. Please re-run the seeder.');
            return;
        }

        // Create or find the admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        $users = [
            [
                'id' => 1,
                'name' => $name,
                'email' => $email,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make($password),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        \App\Models\User::insertOrIgnore($users);

        // Find the newly created user
        $user = \App\Models\User::where('email', $email)->first();

        if ($user) {
            // Assign the "Admin" role to the user
            $user->assignRole($adminRole);

            $this->command->info("Admin user successfully created with email: $email and assigned role: Admin");
        } else {
            $this->command->error("Failed to create admin user.");
        }
    }
}


<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => $this->faker->dateTime(),
            'password' => bcrypt('password'), // Default password
            'lang' => $this->faker->randomElement(['EN', 'DE', 'IT']),
            'taxno' => $this->faker->unique()->numerify('TAX#####'),
            'phone_1' => $this->faker->phoneNumber,
            'phone_2' => $this->faker->optional()->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'factor_id' => $this->faker->optional()->randomNumber(),
            'license' => $this->faker->optional()->bothify('??####'),
            'medical_due' => $this->faker->optional()->date(),
            'params' => null, // Placeholder for optional additional parameters
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * State for creating an Admin user.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'email' => 'admin@example.com', // Specific email for admin
        ])->afterCreating(function (User $user) {
            $user->assignRole(User::IS_ADMIN); // Assign the Admin role
        });
    }

    /**
     * State for creating an Instructor user.
     */
    public function instructor(): static
    {
        return $this->state(fn(array $attributes) => [
            'email' => 'instructor@example.com', // Specific email for instructor
        ])->afterCreating(function (User $user) {
            $user->assignRole(User::IS_INSTRUCTOR); // Assign the Instructor role
        });
    }

    /**
     * State for creating a Member user (default role for most users).
     */
    public function member(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(User::IS_MEMBER); // Assign the Member role
        });
    }
}

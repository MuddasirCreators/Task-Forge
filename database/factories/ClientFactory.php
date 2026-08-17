<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),

            'contact_email' => fake()->unique()->safeEmail(),

            'created_by' => User::factory(),
        ];
    }
}
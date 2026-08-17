<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'name' => fake()->sentence(3),
            'status' => fake()->randomElement([
                'Pending',
                'In Progress',
                'Completed',
            ]),
            'start_date' => fake()->date(),
            'due_date' => fake()->date(),
            'archived_at' => null,
            'created_by' => User::factory(),
        ];
    }
}
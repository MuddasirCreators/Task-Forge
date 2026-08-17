<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskFactory extends Factory
{

    protected $model = Task::class;


    public function definition(): array
    {

        return [

            'project_id' => Project::inRandomOrder()
                ->first()
                ->id,


            'title' => fake()->sentence(3),


            'description' => fake()->paragraph(),


            'status' => fake()->randomElement([

                'Todo',

                'In Progress',

                'Done',

            ]),


            'due_date' => fake()
                ->dateTimeBetween(
                    'now',
                    '+30 days'
                ),

        ];

    }

}
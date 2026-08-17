<?php

namespace Database\Factories;

use App\Models\TimeLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TimeLogFactory extends Factory
{

    protected $model = TimeLog::class;


    public function definition(): array
    {
        return [

            'task_id' => Task::inRandomOrder()->first()?->id,

            'user_id' => User::where('role','Member')
                ->inRandomOrder()
                ->first()?->id,


            'minutes' => fake()
                ->numberBetween(30,480),


            'logged_at' => fake()
                ->dateTimeBetween(
                    '-30 days',
                    'now'
                ),


            'note' => fake()->sentence(),

        ];
    }

}
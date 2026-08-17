<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Database\Seeder;


class TimeLogSeeder extends Seeder
{

    public function run(): void
    {


        $members = User::where('role','Member')
            ->get();


        Task::all()
            ->each(function($task) use ($members){


                TimeLog::factory()
                    ->count(3)
                    ->create([

                        'task_id'=>$task->id,

                        'user_id'=>$members->random()->id,

                    ]);


            });


    }

}
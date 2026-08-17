<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;


class TaskSeeder extends Seeder
{

    public function run(): void
    {


        $members = User::where('role','Member')
            ->get();


        Project::all()
            ->each(function($project) use ($members){


                Task::factory()
                    ->count(3)
                    ->create([

                        'project_id'=>$project->id,

                        'assigned_to'=>$members->random()->id,

                    ]);


            });


    }

}
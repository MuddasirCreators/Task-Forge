<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Get Manager
        |--------------------------------------------------------------------------
        */

        $manager = User::where('role', 'Manager')->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Get Members
        |--------------------------------------------------------------------------
        */

        $members = User::where('role', 'Member')->get();


        /*
        |--------------------------------------------------------------------------
        | Create Projects
        |--------------------------------------------------------------------------
        |
        | 5 Clients × 2 Projects = 10 Projects
        |
        */

        Client::all()->each(function ($client) use ($manager, $members) {

            Project::factory()
                ->count(2)
                ->create([
                    'client_id' => $client->id,
                    'created_by' => $manager->id,
                ])
                ->each(function ($project, $index) use ($members) {

                    /*
                    |--------------------------------------------------------------------------
                    | Assign Realistic Members To Project
                    |--------------------------------------------------------------------------
                    */

                    if ($members->count() >= 3) {

                        $projectNumber = ($project->id % 3);

                        if ($projectNumber === 0) {

                            $assignedMembers = [
                                $members[0]->id,
                                $members[1]->id,
                            ];

                        } elseif ($projectNumber === 1) {

                            $assignedMembers = [
                                $members[1]->id,
                                $members[2]->id,
                            ];

                        } else {

                            $assignedMembers = [
                                $members[0]->id,
                                $members[2]->id,
                            ];
                        }

                        $project->members()->attach($assignedMembers);
                    }
                });
        });
    }
}
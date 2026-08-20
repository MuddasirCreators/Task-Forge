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

        $manager = User::where(
            'role',
            'Manager'
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Get Members
        |--------------------------------------------------------------------------
        */

        $members = User::where(
            'role',
            'Member'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | Create Projects
        |--------------------------------------------------------------------------
        |
        | 5 Clients × 2 Projects = 10 Projects
        |
        */

        Client::all()
            ->each(function ($client) use (
                $manager,
                $members
            ) {

                Project::factory()
                    ->count(2)
                    ->create([
                        'client_id' => $client->id,
                        'created_by' => $manager->id,
                    ])
                    ->each(function ($project) use (
                        $members
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Assign Members To Project
                        |--------------------------------------------------------------------------
                        */

                        if ($members->isNotEmpty()) {

                            $memberCount = min(
                                $members->count(),
                                2
                            );

                            $project->members()->attach(
                                $members
                                    ->random($memberCount)
                                    ->pluck('id')
                                    ->toArray()
                            );
                        }
                    });
            });
    }
}
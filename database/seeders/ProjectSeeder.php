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


        $manager = User::where('role','Manager')->first();


        Client::all()
            ->each(function($client) use ($manager){


                Project::factory()
                    ->count(2)
                    ->create([

                        'client_id'=>$client->id,

                        'created_by'=>$manager->id,

                    ]);


            });


    }

}
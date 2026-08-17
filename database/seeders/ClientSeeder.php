<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;


class ClientSeeder extends Seeder
{

    public function run(): void
    {


        $manager = User::where('role','Manager')->first();


        Client::factory()
            ->count(5)
            ->create([

                'created_by'=>$manager->id

            ]);


    }

}
<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);



test('client cannot be deleted when active projects exist', function () {


    $manager = User::factory()->create([

        'role' => 'Manager',

        'is_active' => true,

    ]);



    $client = Client::factory()->create([

        'name' => 'Test Client',

        'contact_email' => 'client@test.com',

        'created_by' => $manager->id,

    ]);



    Project::factory()->create([

        'client_id' => $client->id,

        'created_by' => $manager->id,

        'name' => 'Active Project',

        'status' => 'In Progress',

    ]);



    $response = $this

        ->actingAs($manager)

        ->delete(

            route(

                'clients.destroy',

                $client

            )

        );



    // Request should be rejected

    $response->assertRedirect();



    // Check client still exists

    expect(Client::find($client->id))

        ->not()

        ->toBeNull();



});
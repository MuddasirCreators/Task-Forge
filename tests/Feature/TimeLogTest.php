<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


function createTimeLogTestUser()
{
    return User::create([

        'name' => 'Member User',

        'email' => 'member@test.com',

        'password' => bcrypt('password'),

        'role' => 'Member',

        'is_active' => true,

        'is_logged_in' => false,

    ]);
}



test('minutes cannot exceed limit', function () {

    $user = createTimeLogTestUser();



    $client = Client::create([

        'name' => 'Test Client',

        'contact_email' => 'client@test.com',

        'created_by' => $user->id,

    ]);



    $project = Project::create([

        'client_id' => $client->id,

        'name' => 'Test Project',

        'status' => 'Pending',

        'start_date' => now(),

        'due_date' => now()->addDays(5),

        'created_by' => $user->id,

    ]);



    // Required because StoreTimeLogRequest checks project membership
    $project->members()->attach($user->id);



    $task = Task::create([

        'project_id' => $project->id,

        'title' => 'Test Task',

        'description' => 'Testing task',

        // Valid Task statuses: Todo, In Progress, Done
        'status' => 'Todo',

        'due_date' => now()->addDays(2),

    ]);



    $response = $this

        ->actingAs($user)

        ->post(

            "/tasks/{$task->id}/time-logs",

            [

                'minutes' => 700,

                'logged_at' => now()->format('Y-m-d'),

                'note' => 'Testing',

            ]

        );



    $response->assertSessionHasErrors([

        'minutes'

    ]);

});
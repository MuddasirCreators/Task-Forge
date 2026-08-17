<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


function createProjectUser()
{
    return User::create([

        'name' => 'Manager User',

        'email' => 'manager@example.com',

        'password' => 'password',

        'role' => 'Manager',

        'is_active' => true,

        'is_logged_in' => false,

    ]);
}



test('manager can create project', function () {

    $user = createProjectUser();


    $client = Client::create([
        'name' => 'Test Client',
        'contact_email' => 'client@test.com',
        'created_by' => $user->id,
    ]);


    $response = $this
        ->actingAs($user)
        ->post('/projects', [

            'client_id' => $client->id,
            'name' => 'Test Project',
            'status' => 'Pending',
            'start_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(10)->format('Y-m-d'),

        ]);


    $response->assertRedirect();


    $this->assertDatabaseHas('projects', [
        'name' => 'Test Project',
    ]);

});



test('project cannot archive with pending tasks', function () {

    $user = createProjectUser();


    $client = Client::create([
        'name' => 'Test Client',
        'contact_email' => 'client@test.com',
        'created_by' => $user->id,
    ]);


    $project = Project::create([

        'client_id' => $client->id,
        'name' => 'Pending Project',
        'status' => 'Pending',
        'start_date' => now(),
        'due_date' => now()->addDays(10),
        'created_by' => $user->id,

    ]);



    Task::create([

        'project_id' => $project->id,
        'title' => 'Pending Task',
        'description' => 'Pending task',
        'status' => 'Pending',
        'priority' => 'High',
        'due_date' => now()->addDays(5),

    ]);



    $response = $this
        ->actingAs($user)
        ->patch("/projects/{$project->id}/archive");


    $response->assertSessionHas('error');

});
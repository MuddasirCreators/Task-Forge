<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;



class TaskTest extends TestCase
{

use RefreshDatabase;



public function test_task_validation_error()
{


$user=User::factory()->create([

'role'=>'Member'

]);


$project=Project::factory()->create();



$response=$this
->actingAs($user)
->post(
"/projects/{$project->id}/tasks",
[

'title'=>'',

]

);



$response->assertSessionHasErrors();


}


}
<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ClientTest extends TestCase
{

use RefreshDatabase;



public function test_manager_can_view_clients()
{


$user = User::factory()->create([

'role'=>'Manager'

]);


$response=$this
->actingAs($user)
->get('/clients');


$response->assertStatus(200);


}



public function test_member_cannot_view_clients()
{


$user=User::factory()->create([

'role'=>'Member'

]);


$response=$this
->actingAs($user)
->get('/clients');


$response->assertStatus(403);


}


}
<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;



class AuthorizationTest extends TestCase
{

use RefreshDatabase;



public function test_admin_can_access_team()
{


$user = User::factory()->create([

    'role'=>'Admin'

]);


$response=$this
->actingAs($user)
->get('/team');


$response->assertStatus(200);


}



public function test_member_cannot_access_team()
{


$user = User::factory()->create([

    'role'=>'Member'

]);


$response=$this
->actingAs($user)
->get('/team');


$response->assertStatus(403);


}


}
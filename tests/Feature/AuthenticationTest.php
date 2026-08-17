<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthenticationTest extends TestCase
{
    use RefreshDatabase;


    public function test_guest_cannot_access_dashboard()
    {

        $response = $this->get('/dashboard');


        $response->assertRedirect('/login');

    }



    public function test_authenticated_user_can_access_dashboard()
    {

        $user = User::factory()->create([
            'role'=>'Admin'
        ]);


        $response = $this
            ->actingAs($user)
            ->get('/dashboard');


        $response->assertStatus(200);

    }

}
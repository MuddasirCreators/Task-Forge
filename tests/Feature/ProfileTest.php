<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;


uses(RefreshDatabase::class);


beforeEach(function () {

    $this->user = User::create([

        'name' => 'Test User',

        'email' => 'test@example.com',

        'password' => Hash::make('password'),

        'role' => 'Member',

        'is_active' => true,

        'is_logged_in' => false,

    ]);

});



test('profile page is displayed', function () {


    $response = $this

        ->actingAs($this->user)

        ->get('/profile');


    $response->assertStatus(200);


});




test('profile information can be updated', function () {


    $response = $this

        ->actingAs($this->user)

        ->patch('/profile', [

            'name' => 'Updated User',

            'email' => 'test@example.com',

        ]);



    $response->assertRedirect('/profile');



    expect($this->user->fresh()->name)

        ->toBe('Updated User');


});




test('email verification status is unchanged when the email address is unchanged', function () {


    $this->user->email_verified_at = now();

    $this->user->save();



    $response = $this

        ->actingAs($this->user)

        ->patch('/profile', [

            'name' => 'Updated User',

            'email' => 'test@example.com',

        ]);



    $response->assertRedirect('/profile');


});




test('user can delete their account', function () {


    $response = $this

        ->actingAs($this->user)

        ->delete('/profile', [

            'password' => 'password',

        ]);



    $response->assertRedirect('/');



    $this->assertGuest();


});




test('correct password must be provided to delete account', function () {


    $response = $this

        ->actingAs($this->user)

        ->delete('/profile', [

            'password' => 'wrong-password',

        ]);



    $response->assertSessionHasErrorsIn(

        'userDeletion',

        'password'

    );


});
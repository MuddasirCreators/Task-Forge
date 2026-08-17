<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;



class RegisteredUserController extends Controller
{


    /**
     * Display the registration page.
     */
    public function create(): View
    {

        return view('auth.register');

    }





    /**
     * Store a newly registered user.
     */
    public function store(
        RegisterUserRequest $request
    ): RedirectResponse
    {


        /*
        |--------------------------------------------------------------------------
        | Get validated data from Request
        |--------------------------------------------------------------------------
        */

        $data = $request->validated();




        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = User::create([


            'name' => $data['name'],


            'email' => $data['email'],


            'password' => Hash::make(
                $data['password']
            ),



            // Default Role

            'role' => 'Member',



            // Account Status

            'is_active' => true,


            'is_logged_in' => false,


        ]);






        /*
        |--------------------------------------------------------------------------
        | Registered Event
        |--------------------------------------------------------------------------
        */

        event(
            new Registered($user)
        );






        /*
        |--------------------------------------------------------------------------
        | Login User Automatically
        |--------------------------------------------------------------------------
        */

        Auth::login($user);






        /*
        |--------------------------------------------------------------------------
        | Redirect Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()

            ->route('dashboard')

            ->with(
                'success',
                'Account created successfully. Welcome to TaskForge!'
            );

    }

}
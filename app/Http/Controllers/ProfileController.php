<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;


class ProfileController extends Controller
{


    /**
     * Display the user's settings page.
     */
    public function edit(Request $request): View
    {
        return view('profile.index', [

            'user' => $request->user(),

        ]);
    }





    /**
     * Update user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {


        $user = $request->user();



        $user->fill(
            $request->validated()
        );



        if ($user->isDirty('email')) {

            $user->email_verified_at = null;

        }



        $user->save();




        return Redirect::route('profile.index')
            ->with(
                'status',
                'profile-updated'
            );

    }





    /**
     * Update phone number.
     */
    public function updatePhone(Request $request): RedirectResponse
    {


        $validated = $request->validate([


            'phone' => [

                'nullable',

                'string',

                'max:20',

            ],


        ]);



        $request->user()->update([


            'phone' => $validated['phone'] ?? null,


        ]);




        return Redirect::route('profile.index')
            ->with(
                'status',
                'phone-updated'
            );

    }





 /**
 * Change password.
 */
public function updatePassword(Request $request): RedirectResponse
{

    $validated = $request->validate([


        'current_password' => [

            'required',

            'current_password',

        ],



        'password' => [

            'required',

            'confirmed',

            Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols(),

        ],


    ],
    [

        'current_password.current_password' =>
            'The current password is incorrect.',


        'password.confirmed' =>
            'The password confirmation does not match.',


        'password.min' =>
            'Password must be at least 8 characters.',

    ]);




    $request->user()->update([


        'password' => Hash::make(

            $validated['password']

        ),


    ]);





    return Redirect::route('profile.index')

        ->with(

            'status',

            'password-updated'

        );


}




    /**
     * Delete user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {


        $request->validateWithBag(
            'userDeletion',
            [

                'password' => [

                    'required',

                    'current_password',

                ],

            ]
        );




        $user = $request->user();



        Auth::logout();



        $user->delete();



        $request->session()->invalidate();



        $request->session()->regenerateToken();



        return Redirect::to('/');

    }


}
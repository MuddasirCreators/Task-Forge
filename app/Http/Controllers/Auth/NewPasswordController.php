<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{

    /**
     * Display password reset form.
     */
    public function create(Request $request, $token): View
    {

        /*
        |--------------------------------------------------------------------------
        | Find reset token record
        |--------------------------------------------------------------------------
        */

        $resetToken = DB::table('password_reset_tokens')
            ->get()
            ->first(function ($item) use ($token) {

                return Hash::check(
                    $token,
                    $item->token
                );

            });



        if (!$resetToken) {

            abort(
                403,
                'Invalid or expired password reset link.'
            );

        }



        return view('auth.reset-password', [

            'request' => $request,

            'token' => $token,

            'email' => $resetToken->email,

        ]);

    }





    /**
     * Handle password reset.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {


        $request->validate([

            'token' => [
                'required'
            ],

            'email' => [
                'required',
                'email'
            ],

            'password' => [

                'required',

                'confirmed',

                Rules\Password::defaults()

            ],

        ]);




        /*
        |--------------------------------------------------------------------------
        | Verify Token Again
        |--------------------------------------------------------------------------
        */


        $resetToken = DB::table('password_reset_tokens')
            ->where(
                'email',
                $request->email
            )
            ->first();



        if (

            !$resetToken ||

            !Hash::check(
                $request->token,
                $resetToken->token
            )

        ) {


            throw ValidationException::withMessages([

                'email' =>
                'Invalid password reset token.'

            ]);

        }





        /*
        |--------------------------------------------------------------------------
        | Reset Password
        |--------------------------------------------------------------------------
        */


        $status = Password::reset(

            $request->only(

                'email',

                'password',

                'password_confirmation',

                'token'

            ),


            function (User $user) use ($request) {


                $user->forceFill([

                    'password' =>
                    Hash::make(
                        $request->password
                    ),


                    'remember_token' =>
                    Str::random(60),

                ])->save();



                event(
                    new PasswordReset($user)
                );


            }

        );





        return $status === Password::PASSWORD_RESET


            ?

            redirect()

                ->route('login')

                ->with(
                    'status',
                    __($status)
                )


            :

            back()

                ->withInput(
                    $request->only('email')
                )

                ->withErrors([

                    'email' =>
                    __($status)

                ]);

    }

}
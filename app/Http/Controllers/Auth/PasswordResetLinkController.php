<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class PasswordResetLinkController extends Controller
{
    /**
     * Display forgot password page.
     */
    public function create(Request $request): View
    {
        return view('auth.forgot-password', [
            'step' => $request->query('step', 'email'),

            // Email stored after sending reset link
            'resetEmail' => $request->session()->get('reset_email', ''),
        ]);
    }


    /**
     * Send password reset link.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Email
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);


        try {

            /*
            |--------------------------------------------------------------------------
            | Send Password Reset Link
            |--------------------------------------------------------------------------
            */

            $status = Password::sendResetLink([
                'email' => $validated['email'],
            ]);



            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            if ($status === Password::RESET_LINK_SENT) {


                // Store email for verify page and resend button

                $request->session()->put(
                    'reset_email',
                    $validated['email']
                );


                $request->session()->save();



                return redirect()->route(
                    'password.request',
                    [
                        'step' => 'verify',
                    ]
                );
            }



            /*
            |--------------------------------------------------------------------------
            | Laravel Password Error
            |--------------------------------------------------------------------------
            */

            return back()
                ->withInput()
                ->withErrors([
                    'email' => __($status),
                ]);



        } catch (TransportExceptionInterface $e) {


            report($e);


            return back()
                ->withInput()
                ->withErrors([
                    'email' =>
                    'Unable to connect with mail server. Please try again later.',
                ]);



        } catch (\Throwable $e) {


            report($e);


            return back()
                ->withInput()
                ->withErrors([
                    'email' =>
                    'Unable to send password reset link. Please try again later.',
                ]);
        }
    }
}
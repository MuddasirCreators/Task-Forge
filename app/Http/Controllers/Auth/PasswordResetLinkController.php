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
     * Display the password reset link request view.
     */
    public function create(Request $request): View
    {
        return view('auth.forgot-password', [
            'step' => $request->query('step', 'email'),
            'resetEmail' => $request->session()->get('reset_email'),
        ]);
    }


    /**
     * Handle password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validate email
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);


        try {

            /*
            |--------------------------------------------------------------------------
            | Send password reset link
            |--------------------------------------------------------------------------
            */

            $status = Password::sendResetLink(
                $request->only('email')
            );


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            if ($status === Password::RESET_LINK_SENT) {

                /*
                |--------------------------------------------------------------------------
                | Store email in session
                |--------------------------------------------------------------------------
                */

                $request->session()->put(
                    'reset_email',
                    $request->email
                );


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | Redirect directly to the Verify step.
                |
                */

                return redirect()->route(
                    'password.request',
                    [
                        'step' => 'verify',
                    ]
                );
            }


            /*
            |--------------------------------------------------------------------------
            | PASSWORD RESET ERROR
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('password.request')
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'email' => __($status),
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | SMTP / MAIL ERROR
        |--------------------------------------------------------------------------
        */

        catch (TransportExceptionInterface $e) {

            report($e);

            return redirect()
                ->route('password.request')
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'email' =>
                        'We could not connect to the email server. '
                        . 'Please try again later.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | OTHER ERROR
        |--------------------------------------------------------------------------
        */

        catch (\Throwable $e) {

            report($e);

            return redirect()
                ->route('password.request')
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'email' =>
                        'Unable to send the password reset link. '
                        . 'Please try again later.',
                ]);
        }
    }
}
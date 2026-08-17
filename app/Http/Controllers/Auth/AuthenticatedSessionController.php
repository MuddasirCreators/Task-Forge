<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show Login Page
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Login User
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Always fetch fresh data from database
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        // Prevent second login
        if ((bool) $user->fresh()->is_logged_in === true) {

            throw ValidationException::withMessages([
                'email' => 'This account is already logged in on another device.',
            ]);
        }

        // Verify password
        $request->authenticate();

        // Create new session
        $request->session()->regenerate();

        // Mark logged in
        $user->update([
            'is_logged_in' => true,
        ]);

        return redirect()
            ->intended(route('dashboard'))
            ->with(
                'success',
                'Welcome back! Login successful.'
            );
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {

            Auth::user()->update([
                'is_logged_in' => false,
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}
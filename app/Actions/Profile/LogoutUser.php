<?php

namespace App\Actions\Profile;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LogoutUser
{


    /**
     * Logout user and clear session.
     */
    public function handle(
        User $user,
        Request $request
    ): void {


        Auth::logout();



        $request->session()->invalidate();



        $request->session()->regenerateToken();


    }


}
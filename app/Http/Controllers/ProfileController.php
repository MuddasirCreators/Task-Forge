<?php

namespace App\Http\Controllers;


use App\Actions\Profile\UpdateProfile;
use App\Actions\Profile\UpdatePhone;
use App\Actions\Profile\UpdatePassword;
use App\Actions\Profile\DeleteAccount;
use App\Actions\Profile\LogoutUser;


use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\DeleteAccountRequest;


use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;



class ProfileController extends Controller
{


    /**
     * Display profile page.
     */
    public function edit(
        Request $request
    ): View {


        return view(
            'profile.index',
            [
                'user' => $request->user()
            ]
        );

    }





    /**
     * Update profile information.
     */
    public function update(
        ProfileUpdateRequest $request,
        UpdateProfile $updateProfile
    ): RedirectResponse {


        $updateProfile->handle(

            $request->user(),

            $request->validated()

        );



        return Redirect::route(
            'profile.index'
        )
        ->with(
            'status',
            'profile-updated'
        );

    }





    /**
     * Update phone number.
     */
    public function updatePhone(
        UpdatePhoneRequest $request,
        UpdatePhone $updatePhone
    ): RedirectResponse {


        $updatePhone->handle(

            $request->user(),

            $request->validated()['phone'] ?? null

        );



        return Redirect::route(
            'profile.index'
        )
        ->with(
            'status',
            'phone-updated'
        );

    }





    /**
     * Update password.
     */
    public function updatePassword(
        UpdatePasswordRequest $request,
        UpdatePassword $updatePassword
    ): RedirectResponse {


        $updatePassword->handle(

            $request->user(),

            $request->validated()['password']

        );



        return Redirect::route(
            'profile.index'
        )
        ->with(
            'status',
            'password-updated'
        );

    }





    /**
     * Delete account.
     */
    public function destroy(
        DeleteAccountRequest $request,
        DeleteAccount $deleteAccount,
        LogoutUser $logoutUser
    ): RedirectResponse {


        $user = $request->user();



        $deleteAccount->handle(

            $user

        );



        $logoutUser->handle(

            $user,

            $request

        );



        return Redirect::to('/');

    }


}
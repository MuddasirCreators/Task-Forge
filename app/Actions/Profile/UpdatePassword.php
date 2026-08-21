<?php

namespace App\Actions\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UpdatePassword
{


    public function handle(
        User $user,
        string $password
    ): void {


        $user->update([

            'password'=>Hash::make($password)

        ]);

    }

}
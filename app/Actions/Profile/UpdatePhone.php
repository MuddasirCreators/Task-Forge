<?php

namespace App\Actions\Profile;

use App\Models\User;


class UpdatePhone
{

    public function handle(
        User $user,
        ?string $phone
    ): void {


        $user->update([

            'phone'=>$phone

        ]);

    }

}
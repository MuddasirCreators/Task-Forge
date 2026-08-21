<?php

namespace App\Actions\Profile;

use App\Models\User;


class DeleteAccount
{

    public function handle(
        User $user
    ): void {


        $user->delete();

    }

}
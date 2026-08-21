<?php

namespace App\Actions\Team;


use App\Models\User;



class ActivateUser
{


    public function handle(
        User $user
    ): void {


        $user->update([

            'is_active'=>true

        ]);

    }


}
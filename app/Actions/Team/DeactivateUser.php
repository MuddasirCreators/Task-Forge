<?php

namespace App\Actions\Team;


use App\Models\User;



class DeactivateUser
{


    public function handle(
        User $user
    ): void {


        $user->update([


            'is_active'=>false,


            'is_logged_in'=>false,


        ]);


    }


}
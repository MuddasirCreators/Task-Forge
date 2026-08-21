<?php

namespace App\Actions\Team;


use App\Models\User;



class UpdateTeamMember
{


    public function handle(
        User $user,
        array $data
    ): void {


        $user->update($data);


    }


}
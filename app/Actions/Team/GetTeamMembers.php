<?php

namespace App\Actions\Team;

use App\Models\User;

class GetTeamMembers
{

    public function handle()
    {
        return User::latest()
            ->paginate(10);
    }

}
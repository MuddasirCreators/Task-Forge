<?php

namespace App\Actions\Tasks;


use App\Models\Project;
use App\Models\User;



class GetAvailableProjects
{


    /**
     * Get projects available for user.
     */
    public function handle(
        User $user
    ) {


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */


        if ($user->role === 'Admin') {


            return Project::with('members')
                ->orderBy('name')
                ->get();

        }



        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */


        if ($user->role === 'Manager') {


            return Project::with('members')
                ->whereHas(
                    'client',
                    function ($query) use ($user) {


                        $query->where(
                            'created_by',
                            $user->id
                        );


                    }
                )
                ->orderBy('name')
                ->get();

        }




        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */


        if ($user->role === 'Member') {


            return Project::with('members')
                ->whereHas(
                    'members',
                    function ($query) use ($user) {


                        $query->where(
                            'users.id',
                            $user->id
                        );


                    }
                )
                ->orderBy('name')
                ->get();

        }



        return collect();

    }

}
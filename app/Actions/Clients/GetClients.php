<?php

namespace App\Actions\Clients;


use App\Models\Client;
use App\Models\User;



class GetClients
{

    /**
     * Get clients according to user role.
     */
    public function handle(
        User $user
    )
    {


        return Client::query()

            ->when(

                $user->role === 'Manager',

                function ($query) use ($user) {

                    $query->where(
                        'created_by',
                        $user->id
                    );

                }

            )

            ->latest()

            ->paginate(10);


    }


}
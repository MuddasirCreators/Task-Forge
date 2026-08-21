<?php

namespace App\Actions\Projects;

use App\Models\Client;
use App\Models\User;

class GetProjectFormData
{

    public function handle(): array
    {

        $user = auth()->user();


        $clients = $user->role === 'Admin'

            ? Client::orderBy('name')->get()

            : Client::where(
                'created_by',
                $user->id
            )
            ->orderBy('name')
            ->get();


        $members = User::where(
            'role',
            'Member'
        )
        ->orderBy('name')
        ->get();


        return [
            'clients'=>$clients,
            'members'=>$members,
        ];

    }

}
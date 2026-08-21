<?php

namespace App\Actions\Projects;

use App\Models\Project;
use App\Models\User;

class GetProjects
{
    public function handle(User $user)
    {
        $query = Project::query()
            ->with([
                'client',
                'creator',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Manager Ownership Rule
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Manager') {

            $query->whereHas(
                'client',
                function ($clientQuery) use ($user) {

                    $clientQuery->where(
                        'created_by',
                        $user->id
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Archived Filter
        |--------------------------------------------------------------------------
        */

        if (request()->boolean('archived')) {

            $query->whereNotNull(
                'archived_at'
            );

        } else {

            $query->whereNull(
                'archived_at'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (request()->filled('status')) {

            $query->where(
                'status',
                request('status')
            );

        }


        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }
}
<?php

namespace App\Actions\Clients;

use App\Events\ClientDeleted;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class DeleteClient
{
    /**
     * Delete a client.
     *
     * Returns false when the client has
     * Pending or In Progress projects.
     */
    public function execute(
        Client $client
    ): bool {
        /*
        |--------------------------------------------------------------------------
        | Prevent Deletion When Active Projects Exist
        |--------------------------------------------------------------------------
        */

        if (
            $client->projects()
                ->whereIn(
                    'status',
                    [
                        'Pending',
                        'In Progress',
                    ]
                )
                ->exists()
        ) {
            return false;
        }

        return DB::transaction(function () use (
            $client
        ) {
            /*
            |--------------------------------------------------------------------------
            | Store Client Information Before Deletion
            |--------------------------------------------------------------------------
            */

            $clientId = $client->id;
            $clientName = $client->name;

            /*
            |--------------------------------------------------------------------------
            | Delete Client
            |--------------------------------------------------------------------------
            */

            $client->delete();

            /*
            |--------------------------------------------------------------------------
            | Client Deleted Audit Event
            |--------------------------------------------------------------------------
            */

            event(
                new ClientDeleted(
                    $clientId,
                    $clientName
                )
            );

            return true;
        });
    }
}
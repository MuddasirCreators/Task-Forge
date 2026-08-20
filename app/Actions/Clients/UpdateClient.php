<?php

namespace App\Actions\Clients;

use App\Events\ClientUpdated;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class UpdateClient
{
    /**
     * Update an existing client.
     */
    public function execute(
        Client $client,
        array $data
    ): Client {
        return DB::transaction(function () use (
            $client,
            $data
        ) {
            $client->update(
                $data
            );

            /*
            |--------------------------------------------------------------------------
            | Refresh Client
            |--------------------------------------------------------------------------
            */

            $client->refresh();

            /*
            |--------------------------------------------------------------------------
            | Client Updated Audit Event
            |--------------------------------------------------------------------------
            */

            event(
                new ClientUpdated(
                    $client
                )
            );

            return $client;
        });
    }
}
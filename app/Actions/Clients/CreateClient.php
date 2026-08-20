<?php

namespace App\Actions\Clients;

use App\Events\ClientCreated;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class CreateClient
{
    /**
     * Create a new client.
     */
    public function execute(
        array $data,
        int $userId
    ): Client {
        return DB::transaction(function () use (
            $data,
            $userId
        ) {
            $client = Client::create([
                ...$data,
                'created_by' => $userId,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Client Created Audit Event
            |--------------------------------------------------------------------------
            */

            event(
                new ClientCreated(
                    $client
                )
            );

            return $client;
        });
    }
}
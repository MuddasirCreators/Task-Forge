<?php

namespace App\Listeners;

use App\Events\ClientCreated;
use App\Models\AuditLog;

class ClientCreatedListener
{
    /**
     * Handle the event.
     */
    public function handle(ClientCreated $event): void
    {
        $client = $event->client;

        AuditLog::create([
            'user_id'        => auth()->id(),
            'action'         => 'client_created',
            'auditable_type' => $client->getMorphClass(),
            'auditable_id'   => $client->id,
            'description'    => 'Client "' . $client->name . '" was created.',
        ]);
    }
}
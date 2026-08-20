<?php

namespace App\Listeners;

use App\Events\ClientUpdated;
use App\Models\AuditLog;

class ClientUpdatedListener
{
    /**
     * Handle the event.
     */
    public function handle(ClientUpdated $event): void
    {
        $client = $event->client;

        AuditLog::create([
            'user_id'        => auth()->id(),
            'action'         => 'client_updated',
            'auditable_type' => $client->getMorphClass(),
            'auditable_id'   => $client->id,
            'description'    => 'Client "' . $client->name . '" was updated.',
        ]);
    }
}
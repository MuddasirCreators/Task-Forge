<?php

namespace App\Listeners;

use App\Events\ClientDeleted;
use App\Models\AuditLog;
use App\Models\Client;

class ClientDeletedListener
{
    /**
     * Handle the event.
     */
    public function handle(ClientDeleted $event): void
    {
        AuditLog::create([
            'user_id'        => auth()->id(),
            'action'         => 'client_deleted',
            'auditable_type' => (new Client)->getMorphClass(),
            'auditable_id'   => $event->clientId,
            'description'    => 'Client "' . $event->clientName . '" was deleted.',
        ]);
    }
}
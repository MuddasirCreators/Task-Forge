<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientDeleted
{
    use Dispatchable, SerializesModels;

    public int $clientId;

    public string $clientName;

    /**
     * Create a new event instance.
     */
    public function __construct(
        int $clientId,
        string $clientName
    ) {
        $this->clientId = $clientId;
        $this->clientName = $clientName;
    }
}
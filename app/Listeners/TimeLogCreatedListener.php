<?php

namespace App\Listeners;

use App\Events\TimeLogCreated;
use App\Models\AuditLog;

class TimeLogCreatedListener
{
    /**
     * Handle the event.
     */
    public function handle(TimeLogCreated $event): void
    {
        $timeLog = $event->timeLog;

        AuditLog::create([
            'user_id'        => auth()->id(),
            'action'         => 'timelog_created',
            'auditable_type' => $timeLog->getMorphClass(),
            'auditable_id'   => $timeLog->id,
            'description'    => 'Time log #' . $timeLog->id . ' was created.',
        ]);
    }
}
<?php

namespace App\Listeners;

use App\Events\TimeLogUpdated;
use App\Models\AuditLog;

class TimeLogUpdatedListener
{
    /**
     * Handle the event.
     */
    public function handle(TimeLogUpdated $event): void
    {
        $timeLog = $event->timeLog;

        AuditLog::create([
            'user_id'        => auth()->id(),
            'action'         => 'timelog_updated',
            'auditable_type' => $timeLog->getMorphClass(),
            'auditable_id'   => $timeLog->id,
            'description'    => 'Time log #' . $timeLog->id . ' was updated.',
        ]);
    }
}
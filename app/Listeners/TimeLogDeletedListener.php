<?php

namespace App\Listeners;

use App\Events\TimeLogDeleted;
use App\Models\AuditLog;
use App\Models\TimeLog;

class TimeLogDeletedListener
{
    /**
     * Handle the event.
     */
    public function handle(TimeLogDeleted $event): void
    {
        AuditLog::create([
            'user_id'        => auth()->id(),
            'action'         => 'timelog_deleted',
            'auditable_type' => (new TimeLog)->getMorphClass(),
            'auditable_id'   => $event->timeLogId,
            'description'    => 'Time log #' . $event->timeLogId . ' was deleted.',
        ]);
    }
}
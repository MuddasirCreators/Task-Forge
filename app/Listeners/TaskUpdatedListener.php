<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use App\Models\AuditLog;

class TaskUpdatedListener
{
    public function handle(TaskUpdated $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'task_updated',

            'auditable_type' => \App\Models\Task::class,

            'auditable_id' => $event->task->id,

            'description' =>
                'Task "' .
                $event->task->title .
                '" was updated.',
        ]);
    }
}
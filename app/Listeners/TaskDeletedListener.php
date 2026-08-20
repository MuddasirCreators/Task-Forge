<?php

namespace App\Listeners;

use App\Events\TaskDeleted;
use App\Models\AuditLog;

class TaskDeletedListener
{
    public function handle(TaskDeleted $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'task_deleted',

            'auditable_type' => \App\Models\Task::class,

            'auditable_id' => $event->taskId,

            'description' =>
                'Task "' .
                $event->taskTitle .
                '" was deleted.',
        ]);
    }
}
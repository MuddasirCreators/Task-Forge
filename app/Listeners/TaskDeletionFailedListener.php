<?php

namespace App\Listeners;

use App\Events\TaskDeletionFailed;
use App\Models\AuditLog;

class TaskDeletionFailedListener
{
    public function handle(TaskDeletionFailed $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'task_deletion_failed',

            'auditable_type' => \App\Models\Task::class,

            'auditable_id' => $event->task->id,

            'description' =>
                'Attempted to delete task "' .
                $event->task->title .
                '" but deletion failed: ' .
                $event->reason,
        ]);
    }
}
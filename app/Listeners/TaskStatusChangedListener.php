<?php

namespace App\Listeners;

use App\Events\TaskStatusChanged;
use App\Models\AuditLog;

class TaskStatusChangedListener
{
    public function handle(TaskStatusChanged $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'task_status_changed',

            'auditable_type' => \App\Models\Task::class,

            'auditable_id' => $event->task->id,

            'description' =>
                'Task "' .
                $event->task->title .
                '" status changed from "' .
                $event->oldStatus .
                '" to "' .
                $event->newStatus .
                '".',
        ]);
    }
}
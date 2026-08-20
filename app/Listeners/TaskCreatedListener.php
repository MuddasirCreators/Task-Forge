<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Models\AuditLog;

class TaskCreatedListener
{
    public function handle(TaskCreated $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'task_created',

            'auditable_type' => \App\Models\Task::class,

            'auditable_id' => $event->task->id,

            'description' =>
                'Task "' .
                $event->task->title .
                '" was created.',
        ]);
    }
}
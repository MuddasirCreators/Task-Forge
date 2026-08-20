<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Models\AuditLog;
use App\Models\User;

class TaskAssignedListener
{
    public function handle(TaskAssigned $event): void
    {
        $oldUser = $event->oldAssigneeId
            ? User::find($event->oldAssigneeId)
            : null;

        $newUser = $event->newAssigneeId
            ? User::find($event->newAssigneeId)
            : null;

        $oldName = $oldUser
            ? $oldUser->name
            : 'Unassigned';

        $newName = $newUser
            ? $newUser->name
            : 'Unassigned';

        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'task_assigned',

            'auditable_type' => \App\Models\Task::class,

            'auditable_id' => $event->task->id,

            'description' =>
                'Task "' .
                $event->task->title .
                '" assignment changed from "' .
                $oldName .
                '" to "' .
                $newName .
                '".',
        ]);
    }
}
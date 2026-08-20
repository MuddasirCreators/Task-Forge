<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssigned
{
    use Dispatchable, SerializesModels;

    public Task $task;

    public int|string|null $oldAssigneeId;

    public int|string|null $newAssigneeId;

    public function __construct(
        Task $task,
        int|string|null $oldAssigneeId,
        int|string|null $newAssigneeId
    ) {
        $this->task = $task;
        $this->oldAssigneeId = $oldAssigneeId;
        $this->newAssigneeId = $newAssigneeId;
    }
}
<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDeletionFailed
{
    use Dispatchable, SerializesModels;

    public Task $task;

    public string $reason;

    public function __construct(
        Task $task,
        string $reason
    ) {
        $this->task = $task;
        $this->reason = $reason;
    }
}
<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDeleted
{
    use Dispatchable, SerializesModels;

    public int $taskId;

    public int $projectId;

    public string $taskTitle;

    public function __construct(
        int $taskId,
        int $projectId,
        string $taskTitle
    ) {
        $this->taskId = $taskId;
        $this->projectId = $projectId;
        $this->taskTitle = $taskTitle;
    }
}
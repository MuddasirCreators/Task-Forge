<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TimeLogDeleted
{
    use Dispatchable, SerializesModels;

    public int $timeLogId;

    public int $taskId;

    public int $userId;

    public int $minutes;

    /**
     * Create a new event instance.
     */
    public function __construct(
        int $timeLogId,
        int $taskId,
        int $userId,
        int $minutes
    ) {
        $this->timeLogId = $timeLogId;
        $this->taskId = $taskId;
        $this->userId = $userId;
        $this->minutes = $minutes;
    }
}
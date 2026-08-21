<?php

namespace App\Actions\TimeLogs;

use App\Models\Task;


class GetTimeLogs
{

    /**
     * Get paginated time logs for task.
     */
    public function handle(Task $task)
    {
        return $task
            ->timeLogs()
            ->with('user')
            ->latest()
            ->paginate(10);
    }

}
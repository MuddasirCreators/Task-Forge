<?php

namespace App\Actions\Tasks;

use App\Models\Task;


class GetTaskDetails
{

    /**
     * Load task details.
     */
    public function handle(
        Task $task
    ): Task {

        return $task->load([
            'project',
            'assignee',
            'timeLogs.user'
        ]);

    }

}
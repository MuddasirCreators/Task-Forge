<?php

namespace App\Actions\Tasks;

use App\Models\Project;
use App\Models\Task;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class VerifyTaskProject
{

    /**
     * Verify task belongs to given project.
     */
    public function handle(
        Project $project,
        Task $task
    ): void {

        if ((int) $task->project_id !== (int) $project->id) {

            throw new NotFoundHttpException(
                'Task does not belong to this project.'
            );

        }

    }

}
<?php

namespace App\Actions\Tasks;

use App\Events\TaskDeleted;
use App\Events\TaskDeletionFailed;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class DeleteTask
{
    /**
     * Delete the specified task.
     */
    public function handle(Task $task): void
    {
        /*
        |--------------------------------------------------------------------------
        | Store Task Information Before Deletion
        |--------------------------------------------------------------------------
        |
        | The Task model may no longer be available after delete().
        |
        */

        $taskId = $task->id;

        $projectId = $task->project_id;

        $taskTitle = $task->title;

        try {
            /*
            |--------------------------------------------------------------------------
            | Business Rule
            |--------------------------------------------------------------------------
            | A task cannot be deleted if it has time logs.
            |--------------------------------------------------------------------------
            */

            if ($task->timeLogs()->exists()) {
                throw ValidationException::withMessages([
                    'task' =>
                        'This task cannot be deleted because it has associated time logs.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Delete Task
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (
                $task
            ) {
                $task->delete();
            });

            /*
            |--------------------------------------------------------------------------
            | Successful Delete Audit Event
            |--------------------------------------------------------------------------
            */

            TaskDeleted::dispatch(
                $taskId,
                $projectId,
                $taskTitle
            );
        } catch (Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Failed Delete Audit Event
            |--------------------------------------------------------------------------
            */

            TaskDeletionFailed::dispatch(
                $task,
                $exception->getMessage()
            );

            throw $exception;
        }
    }
}
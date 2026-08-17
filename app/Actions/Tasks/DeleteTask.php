<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use Illuminate\Validation\ValidationException;

class DeleteTask
{
    /**
     * Delete the specified task.
     */
    public function handle(Task $task): void
    {
        /*
        |--------------------------------------------------------------------------
        | Business Rule
        |--------------------------------------------------------------------------
        | A task cannot be deleted if it has time logs.
        |--------------------------------------------------------------------------
        */

        if ($task->timeLogs()->exists()) {

            throw ValidationException::withMessages([

                'task' => 'This task cannot be deleted because it has associated time logs.',

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Delete Task
        |--------------------------------------------------------------------------
        */

        $task->delete();
    }
}
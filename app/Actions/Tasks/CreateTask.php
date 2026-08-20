<?php

namespace App\Actions\Tasks;

use App\Events\TaskCreated;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateTask
{
    /**
     * Create a new task.
     */
    public function handle(array $data): Task
    {
        $project = Project::findOrFail(
            $data['project_id']
        );

        $dueDate = Carbon::parse(
            $data['due_date']
        );

        $projectStart = Carbon::parse(
            $project->start_date
        );

        /*
        |--------------------------------------------------------------------------
        | Business Rule
        |--------------------------------------------------------------------------
        | Task due date cannot be before project start date.
        |--------------------------------------------------------------------------
        */

        if ($dueDate->lt($projectStart)) {
            throw ValidationException::withMessages([
                'due_date' =>
                    'Task due date cannot be before the project start date.',
            ]);
        }

        return DB::transaction(function () use (
            $project,
            $data
        ) {
            $task = Task::create([
                'project_id'  => $project->id,
                'title'       => trim($data['title']),
                'description' => isset($data['description'])
                    ? trim($data['description'])
                    : null,
                'status'      => trim($data['status']),
                'priority'    => $data['priority'],
                'assigned_to' => $data['assigned_to'],
                'due_date'    => $data['due_date'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Task Created Audit Event
            |--------------------------------------------------------------------------
            */

            TaskCreated::dispatch(
                $task
            );

            return $task;
        });
    }
}
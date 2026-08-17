<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Validation\ValidationException;

class UpdateTask
{
    /**
     * Update an existing Task.
     */
    public function handle(Task $task, array $data): Task
    {
        /*
        |--------------------------------------------------------------------------
        | Get Project
        |--------------------------------------------------------------------------
        */

        $project = Project::findOrFail($data['project_id']);

        /*
        |--------------------------------------------------------------------------
        | Business Rule
        | Task due date cannot be before Project start date.
        |--------------------------------------------------------------------------
        */

        if (
            strtotime($data['due_date']) <
            strtotime($project->start_date)
        ) {
            throw ValidationException::withMessages([
                'due_date' => 'Task due date cannot be before the project start date.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Update Task
        |--------------------------------------------------------------------------
        */

        $task->update([
            'project_id'  => $project->id,
            'title'       => trim($data['title']),
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
            'priority'    => $data['priority'],        // ← ADDED
            'assigned_to' => $data['assigned_to'],     // ← ADDED
            'due_date'    => $data['due_date'],
        ]);

        return $task->fresh();
    }
}
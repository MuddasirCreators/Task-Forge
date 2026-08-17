<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use App\Models\Project;
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
        $project = Project::findOrFail($data['project_id']);

        $dueDate = Carbon::parse($data['due_date']);
        $projectStart = Carbon::parse($project->start_date);

        /*
        |--------------------------------------------------------------------------
        | Business Rule
        |--------------------------------------------------------------------------
        */

        if ($dueDate->lt($projectStart)) {
            throw ValidationException::withMessages([
                'due_date' => 'Task due date cannot be before the project start date.',
            ]);
        }

        return DB::transaction(function () use ($project, $data) {

            return Task::create([
                'project_id'  => $project->id,
                'title'       => trim($data['title']),
                'description' => isset($data['description'])
                    ? trim($data['description'])
                    : null,
                'status'      => trim($data['status']),
                'priority'    => $data['priority'],          // ← ADDED
                'assigned_to' => $data['assigned_to'],       // ← ADDED
                'due_date'    => $data['due_date'],
            ]);

        });
    }
}
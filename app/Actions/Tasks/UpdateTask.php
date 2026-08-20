<?php

namespace App\Actions\Tasks;

use App\Events\TaskAssigned;
use App\Events\TaskStatusChanged;
use App\Events\TaskUpdated;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateTask
{
    /**
     * Update an existing task.
     */
    public function handle(
        Task $task,
        array $data
    ): Task {
        /*
        |--------------------------------------------------------------------------
        | Get Project
        |--------------------------------------------------------------------------
        */

        $project = Project::findOrFail(
            $data['project_id']
        );

        /*
        |--------------------------------------------------------------------------
        | Business Rule
        |--------------------------------------------------------------------------
        | Task due date cannot be before project start date.
        |--------------------------------------------------------------------------
        */

        if (
            strtotime($data['due_date']) <
            strtotime($project->start_date)
        ) {
            throw ValidationException::withMessages([
                'due_date' =>
                    'Task due date cannot be before the project start date.',
            ]);
        }

        return DB::transaction(function () use (
            $task,
            $project,
            $data
        ) {
            /*
            |--------------------------------------------------------------------------
            | Store Old Values
            |--------------------------------------------------------------------------
            */

            $oldAssigneeId = $task->assigned_to;

            $oldStatus = $task->status;

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
                'priority'    => $data['priority'],
                'assigned_to' => $data['assigned_to'],
                'due_date'    => $data['due_date'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Refresh Task
            |--------------------------------------------------------------------------
            */

            $task->refresh();

            /*
            |--------------------------------------------------------------------------
            | Detect Assignment Change
            |--------------------------------------------------------------------------
            */

            $assignmentChanged =
                (string) $oldAssigneeId !==
                (string) $task->assigned_to;

            /*
            |--------------------------------------------------------------------------
            | Detect Status Change
            |--------------------------------------------------------------------------
            */

            $statusChanged =
                (string) $oldStatus !==
                (string) $task->status;

            /*
            |--------------------------------------------------------------------------
            | Assignment Audit Event
            |--------------------------------------------------------------------------
            */

            if ($assignmentChanged) {
                TaskAssigned::dispatch(
                    $task,
                    $oldAssigneeId,
                    $task->assigned_to
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Status Audit Event
            |--------------------------------------------------------------------------
            */

            if ($statusChanged) {
                TaskStatusChanged::dispatch(
                    $task,
                    $oldStatus,
                    $task->status
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Generic Update Audit Event
            |--------------------------------------------------------------------------
            |
            | Preserve your existing behavior:
            | TaskUpdated is recorded only when the change is
            | not assignment-only and not status-only.
            |--------------------------------------------------------------------------
            */

            if (
                !$assignmentChanged &&
                !$statusChanged
            ) {
                TaskUpdated::dispatch(
                    $task
                );
            }

            return $task;
        });
    }
}
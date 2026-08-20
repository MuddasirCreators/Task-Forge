<?php

namespace App\Actions\Projects;

use App\Events\ProjectStatusChanged;
use App\Events\ProjectUpdated;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectAssignedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateProject
{
    /**
     * Update a project.
     *
     * @throws ValidationException
     */
    public function handle(
        Project $project,
        array $data,
        array $memberIds = []
    ): Project {
        /*
        |--------------------------------------------------------------------------
        | Archived Projects
        |--------------------------------------------------------------------------
        */

        if ($project->archived_at) {
            throw ValidationException::withMessages([
                'project' => 'Archived projects cannot be updated.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Completion Validation
        |--------------------------------------------------------------------------
        */

        if (
            ($data['status'] ?? null) === 'Completed'
            && $project->tasks()->count() === 0
        ) {
            throw ValidationException::withMessages([
                'status' =>
                    'A project must have at least one task before it can be marked as Completed.',
            ]);
        }

        if (
            ($data['status'] ?? null) === 'Completed'
            && $project->tasks()
                ->where('status', '!=', 'Done')
                ->exists()
        ) {
            throw ValidationException::withMessages([
                'status' =>
                    'All project tasks must be marked as Done before completing the project.',
            ]);
        }

        return DB::transaction(function () use (
            $project,
            $data,
            $memberIds
        ) {
            /*
            |--------------------------------------------------------------------------
            | Save Old Values
            |--------------------------------------------------------------------------
            */

            $oldMemberIds = $project->members()
                ->pluck('users.id')
                ->map(fn ($id) => (int) $id)
                ->toArray();

            $oldStatus = $project->status;

            /*
            |--------------------------------------------------------------------------
            | Update Project
            |--------------------------------------------------------------------------
            */

            $project->update([
                'client_id'  => $data['client_id'],
                'name'       => $data['name'],
                'status'     => $data['status'],
                'start_date' => $data['start_date'],
                'due_date'   => $data['due_date'],
            ]);

            $project->refresh();

            /*
            |--------------------------------------------------------------------------
            | Audit: Project Updated
            |--------------------------------------------------------------------------
            */

            ProjectUpdated::dispatch(
                $project
            );

            /*
            |--------------------------------------------------------------------------
            | Audit: Status Changed
            |--------------------------------------------------------------------------
            */

            if ($oldStatus !== $project->status) {
                ProjectStatusChanged::dispatch(
                    $project,
                    $oldStatus,
                    $project->status
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Sync Project Members
            |--------------------------------------------------------------------------
            */

            $newMemberIds = array_values(
                array_unique(
                    array_map(
                        'intval',
                        $memberIds
                    )
                )
            );

            $project->members()->sync(
                $newMemberIds
            );

            /*
            |--------------------------------------------------------------------------
            | Notify Newly Assigned Members
            |--------------------------------------------------------------------------
            */

            $newlyAssignedIds = array_values(
                array_diff(
                    $newMemberIds,
                    $oldMemberIds
                )
            );

            if (!empty($newlyAssignedIds)) {
                $newUsers = User::whereIn(
                    'id',
                    $newlyAssignedIds
                )->get();

                foreach ($newUsers as $user) {
                    $user->notify(
                        new ProjectAssignedNotification(
                            $project
                        )
                    );
                }
            }

            return $project;
        });
    }
}
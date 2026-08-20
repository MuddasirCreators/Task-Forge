<?php

namespace App\Actions\Projects;

use App\Events\ProjectCreated;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectAssignedNotification;
use Illuminate\Support\Facades\DB;

class CreateProject
{
    /**
     * Create a new project, assign members,
     * record the audit event and notify members.
     */
    public function handle(
        array $data,
        int $createdBy,
        array $memberIds = []
    ): Project {
        return DB::transaction(function () use (
            $data,
            $createdBy,
            $memberIds
        ) {
            $project = Project::create([
                'client_id'  => $data['client_id'],
                'name'       => $data['name'],
                'status'     => $data['status'],
                'start_date' => $data['start_date'],
                'due_date'   => $data['due_date'],
                'created_by' => $createdBy,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Audit: Project Created
            |--------------------------------------------------------------------------
            */

            ProjectCreated::dispatch($project);

            /*
            |--------------------------------------------------------------------------
            | Assign Members
            |--------------------------------------------------------------------------
            */

            $memberIds = array_values(
                array_unique(
                    array_map(
                        'intval',
                        $memberIds
                    )
                )
            );

            $project->members()->sync($memberIds);

            /*
            |--------------------------------------------------------------------------
            | Notify Assigned Members
            |--------------------------------------------------------------------------
            */

            if (!empty($memberIds)) {
                $users = User::whereIn(
                    'id',
                    $memberIds
                )->get();

                foreach ($users as $user) {
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
<?php

namespace App\Actions\Projects;

use App\Events\ProjectArchived;
use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\DB;

class ArchiveProject
{
    /**
     * Archive a project.
     *
     * Business rules:
     *
     * - Project must not already be archived.
     * - Project must be Completed.
     * - All project tasks must be Done.
     */
    public function handle(Project $project): void
    {
        /*
        |--------------------------------------------------------------------------
        | Already Archived
        |--------------------------------------------------------------------------
        */

        if ($project->archived_at) {
            throw new Exception(
                'This project is already archived.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Project Must Be Completed
        |--------------------------------------------------------------------------
        */

        if ($project->status !== 'Completed') {
            throw new Exception(
                'Only completed projects can be archived.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | All Tasks Must Be Done
        |--------------------------------------------------------------------------
        */

        if (
            $project->tasks()
                ->where(
                    'status',
                    '!=',
                    'Done'
                )
                ->exists()
        ) {
            throw new Exception(
                'Project cannot be archived until all tasks are completed.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Archive Project
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($project) {

            $project->update([
                'archived_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Project Archived Event
            |--------------------------------------------------------------------------
            */

            ProjectArchived::dispatch(
                $project
            );
        });
    }
}
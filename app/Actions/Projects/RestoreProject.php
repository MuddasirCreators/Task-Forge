<?php

namespace App\Actions\Projects;

use App\Events\ProjectRestored;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RestoreProject
{
    /**
     * Restore an archived project.
     */
    public function handle(
        Project $project
    ): Project {
        if (!$project->archived_at) {
            throw ValidationException::withMessages([
                'project' => 'Project is already active.',
            ]);
        }

        return DB::transaction(function () use (
            $project
        ) {
            $project->update([
                'archived_at' => null,
            ]);

            $project->refresh();

            /*
            |--------------------------------------------------------------------------
            | Audit: Project Restored
            |--------------------------------------------------------------------------
            */

            ProjectRestored::dispatch(
                $project
            );

            return $project;
        });
    }
}
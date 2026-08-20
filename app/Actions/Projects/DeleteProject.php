<?php

namespace App\Actions\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class DeleteProject
{
    /**
     * Delete a project.
     *
     * Returns false when the project has tasks.
     */
    public function handle(
        Project $project
    ): bool {
        /*
        |--------------------------------------------------------------------------
        | Prevent Deletion When Tasks Exist
        |--------------------------------------------------------------------------
        */

        if ($project->tasks()->exists()) {
            return false;
        }

        return DB::transaction(function () use (
            $project
        ) {
            $project->delete();

            return true;
        });
    }
}
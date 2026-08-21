<?php

namespace App\Actions\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class DeleteProject
{
    /**
     * Delete a project.
     *
     * Business rules:
     * - Project cannot be deleted if it has associated tasks.
     * - Project deletion must happen inside a transaction.
     *
     * @return array{
     *     success: bool,
     *     message: string
     * }
     */
    public function handle(
        Project $project
    ): array {


        /*
        |--------------------------------------------------------------------------
        | Prevent Deletion When Tasks Exist
        |--------------------------------------------------------------------------
        */

        if ($project->tasks()->exists()) {

            return [
                'success' => false,
                'message' =>
                    'Project cannot be deleted because it has associated tasks.'
            ];
        }



        /*
        |--------------------------------------------------------------------------
        | Delete Project
        |--------------------------------------------------------------------------
        */

        return DB::transaction(function () use ($project) {


            $project->delete();


            return [
                'success' => true,
                'message' =>
                    'Project deleted successfully.'
            ];

        });

    }
}
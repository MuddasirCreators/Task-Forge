<?php

namespace App\Actions\Projects;

use App\Models\Project;
use Exception;

class ArchiveProject
{
    /**
     * Archive the project.
     */
    public function handle(Project $project): void
    {
        if ($project->archived_at) {

            throw new Exception(
                'This project is already archived.'
            );

        }

        $project->update([

            'archived_at' => now(),

        ]);
    }
}
<?php

namespace App\Actions\Projects;

use App\Models\Project;

class GetProjectDetails
{
    /**
     * Load complete project details.
     *
     * @param Project $project
     * @return Project
     */
    public function handle(Project $project): Project
    {
        return $project->load([
            'client',
            'creator',
            'tasks',
            'members'
        ]);
    }
}
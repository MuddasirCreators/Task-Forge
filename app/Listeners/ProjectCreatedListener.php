<?php

namespace App\Listeners;

use App\Events\ProjectCreated;
use App\Models\AuditLog;
use App\Models\Project;

class ProjectCreatedListener
{
    public function handle(ProjectCreated $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'project_created',
            'auditable_type' => Project::class,
            'auditable_id' => $event->project->id,
            'description' => 'Project "' . $event->project->name . '" was created.',
        ]);
    }
}
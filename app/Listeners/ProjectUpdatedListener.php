<?php

namespace App\Listeners;

use App\Events\ProjectUpdated;
use App\Models\AuditLog;
use App\Models\Project;

class ProjectUpdatedListener
{
    public function handle(ProjectUpdated $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'project_updated',
            'auditable_type' => Project::class,
            'auditable_id' => $event->project->id,
            'description' => 'Project "' . $event->project->name . '" was updated.',
        ]);
    }
}
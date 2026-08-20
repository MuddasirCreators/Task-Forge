<?php

namespace App\Listeners;

use App\Events\ProjectArchived;
use App\Models\AuditLog;

class ProjectArchivedListener
{
    public function handle(ProjectArchived $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'project_archived',
            'auditable_type' => $event->project->getMorphClass(),
            'auditable_id' => $event->project->id,
            'description' => 'Project "' . $event->project->name . '" was archived.',
        ]);
    }
}
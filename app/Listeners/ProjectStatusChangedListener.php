<?php

namespace App\Listeners;

use App\Events\ProjectStatusChanged;
use App\Models\AuditLog;
use App\Models\Project;

class ProjectStatusChangedListener
{
    public function handle(ProjectStatusChanged $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'project_status_changed',
            'auditable_type' => Project::class,
            'auditable_id' => $event->project->id,
            'description' =>
                'Project "' . $event->project->name .
                '" status changed from "' . $event->oldStatus .
                '" to "' . $event->newStatus . '".',
        ]);
    }
}
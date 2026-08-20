<?php

namespace App\Listeners;

use App\Events\ProjectRestored;
use App\Models\AuditLog;
use App\Models\Project;

class ProjectRestoredListener
{
    public function handle(ProjectRestored $event): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'project_restored',
            'auditable_type' => Project::class,
            'auditable_id' => $event->project->id,
            'description' => 'Project "' . $event->project->name . '" was restored.',
        ]);
    }
}
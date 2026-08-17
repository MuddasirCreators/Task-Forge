<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Actions\Projects\ArchiveProject;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Notifications\ProjectAssignedNotification;

class ProjectController extends Controller
{
    /**
     * Display Projects
     */
    public function index()
    {
        $query = Project::with([
            'client',
            'creator',
        ]);

        // Active / Archived
        if (request()->boolean('archived')) {
            $query->whereNotNull('archived_at');
        } else {
            $query->whereNull('archived_at');
        }

        // Status Filter
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $projects = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

        $members = User::where('role', 'Member')
            ->orderBy('name')
            ->get();

        return view('projects.create', compact(
            'clients',
            'members'
        ));
    }

    /**
     * Store Project
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'client_id'   => $request->client_id,
            'name'        => $request->name,
            'status'      => $request->status,
            'start_date'  => $request->start_date,
            'due_date'    => $request->due_date,
            'created_by'  => auth()->id(),
        ]);

        $memberIds = $request->member_ids ?? [];

        $project->members()->sync($memberIds);

        // Send notification to assigned members
        if (!empty($memberIds)) {
            $users = User::whereIn('id', $memberIds)->get();

            foreach ($users as $user) {
                $user->notify(new ProjectAssignedNotification($project));
            }
        }

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Show Project
     */
    public function show(Project $project)
    {
        $project->load([
            'client',
            'creator',
            'tasks',
            'members',
        ]);

        return view('projects.show', compact('project'));
    }

    /**
     * Edit Project
     */
    public function edit(Project $project)
    {
        if ($project->archived_at) {
            return redirect()
                ->route('projects.index')
                ->with('error', 'Archived projects cannot be edited.');
        }

        $clients = Client::orderBy('name')->get();

        $members = User::where('role', 'Member')
            ->orderBy('name')
            ->get();

        return view('projects.edit', compact(
            'project',
            'clients',
            'members'
        ));
    }

    /**
     * Update Project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if ($project->archived_at) {
            return redirect()
                ->route('projects.index')
                ->with('error', 'Archived projects cannot be updated.');
        }

        /*
        |--------------------------------------------------------------------------
        | Project cannot be completed without tasks
        |--------------------------------------------------------------------------
        */
        if (
            $request->status === 'Completed' &&
            $project->tasks()->count() === 0
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'status' => 'A project must have at least one task before it can be marked as Completed.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Every task must be Done
        |--------------------------------------------------------------------------
        */
        if (
            $request->status === 'Completed' &&
            $project->tasks()
                ->where('status', '!=', 'Done')
                ->exists()
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'status' => 'All project tasks must be marked as Done before completing the project.',
                ]);
        }

        // Old members before update
        $oldMemberIds = $project->members()->pluck('users.id')->toArray();

        $project->update([
            'client_id'  => $request->client_id,
            'name'       => $request->name,
            'status'     => $request->status,
            'start_date' => $request->start_date,
            'due_date'   => $request->due_date,
        ]);

        $newMemberIds = $request->member_ids ?? [];

        $project->members()->sync($newMemberIds);

        // Notify only newly added members
        $newlyAssignedIds = array_diff($newMemberIds, $oldMemberIds);

        if (!empty($newlyAssignedIds)) {
            $newUsers = User::whereIn('id', $newlyAssignedIds)->get();

            foreach ($newUsers as $user) {
                $user->notify(new ProjectAssignedNotification($project));
            }
        }

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Archive Project
     */
    public function archive(Project $project, ArchiveProject $archiveProject)
    {
        /*
        |--------------------------------------------------------------------------
        | Only completed projects can be archived
        |--------------------------------------------------------------------------
        */
        if ($project->status !== 'Completed') {
            return redirect()
                ->route('projects.index')
                ->with('error', 'Only completed projects can be archived.');
        }

        /*
        |--------------------------------------------------------------------------
        | Double check all tasks are completed
        |--------------------------------------------------------------------------
        */
        if (
            $project->tasks()
                ->where('status', '!=', 'Done')
                ->exists()
        ) {
            return redirect()
                ->route('projects.index')
                ->with('error', 'Project cannot be archived until all tasks are completed.');
        }

        try {
            $archiveProject->handle($project);

            return redirect()
                ->route('projects.index')
                ->with('success', 'Project archived successfully.');
        } catch (Exception $exception) {
            return redirect()
                ->route('projects.index')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Restore Project
     */
    public function restore(Project $project)
    {
        if (!$project->archived_at) {
            return redirect()
                ->route('projects.index')
                ->with('error', 'Project is already active.');
        }

        $project->update([
            'archived_at' => null,
        ]);

        return redirect()
            ->route('projects.index', ['archived' => 1])
            ->with('success', 'Project restored successfully.');
    }

    /**
     * Delete Project
     */
    public function destroy(Project $project)
    {
        if ($project->tasks()->exists()) {
            return redirect()
                ->route('projects.index')
                ->with('error', 'Project cannot be deleted because it has associated tasks.');
        }

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
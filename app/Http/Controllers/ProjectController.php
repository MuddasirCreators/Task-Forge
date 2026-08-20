<?php

namespace App\Http\Controllers;

use App\Actions\Projects\ArchiveProject;
use App\Actions\Projects\CreateProject;
use App\Actions\Projects\DeleteProject;
use App\Actions\Projects\RestoreProject;
use App\Actions\Projects\UpdateProject;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    /**
     * Display Projects.
     */
    public function index()
    {
        Gate::authorize(
            'viewAny',
            Project::class
        );

        $query = Project::with([
            'client',
            'creator',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'Manager') {
            $query->whereHas(
                'client',
                function ($query) {
                    $query->where(
                        'created_by',
                        auth()->id()
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Archived / Active Projects
        |--------------------------------------------------------------------------
        */

        if (request()->boolean('archived')) {
            $query->whereNotNull(
                'archived_at'
            );
        } else {
            $query->whereNull(
                'archived_at'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (request()->filled('status')) {
            $query->where(
                'status',
                request('status')
            );
        }

        $projects = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'projects.index',
            compact('projects')
        );
    }


    /**
     * Show Create Form.
     */
    public function create()
    {
        Gate::authorize(
            'create',
            Project::class
        );

        /*
        |--------------------------------------------------------------------------
        | Clients
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'Admin') {
            $clients = Client::orderBy(
                'name'
            )->get();
        } else {
            $clients = Client::where(
                'created_by',
                auth()->id()
            )
                ->orderBy('name')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Members
        |--------------------------------------------------------------------------
        */

        $members = User::where(
            'role',
            'Member'
        )
            ->orderBy('name')
            ->get();

        return view(
            'projects.create',
            compact(
                'clients',
                'members'
            )
        );
    }


    /**
     * Store Project.
     */
    public function store(
        StoreProjectRequest $request,
        CreateProject $createProject
    ) {
        Gate::authorize(
            'create',
            Project::class
        );

        $createProject->handle(
            $request->validated(),
            auth()->id(),
            $request->validated('member_ids') ?? []
        );

        return redirect()
            ->route(
                'projects.index'
            )
            ->with(
                'success',
                'Project created successfully.'
            );
    }


    /**
     * Show Project.
     */
    public function show(
        Project $project
    ) {
        Gate::authorize(
            'view',
            $project
        );

        $project->load([
            'client',
            'creator',
            'tasks',
            'members',
        ]);

        return view(
            'projects.show',
            compact('project')
        );
    }


    /**
     * Edit Project.
     */
    public function edit(
        Project $project
    ) {
        Gate::authorize(
            'update',
            $project
        );

        if ($project->archived_at) {
            return redirect()
                ->route(
                    'projects.index'
                )
                ->with(
                    'error',
                    'Archived projects cannot be edited.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Clients
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'Admin') {
            $clients = Client::orderBy(
                'name'
            )->get();
        } else {
            $clients = Client::where(
                'created_by',
                auth()->id()
            )
                ->orderBy('name')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Members
        |--------------------------------------------------------------------------
        */

        $members = User::where(
            'role',
            'Member'
        )
            ->orderBy('name')
            ->get();

        return view(
            'projects.edit',
            compact(
                'project',
                'clients',
                'members'
            )
        );
    }


    /**
     * Update Project.
     */
    public function update(
        UpdateProjectRequest $request,
        Project $project,
        UpdateProject $updateProject
    ) {
        Gate::authorize(
            'update',
            $project
        );

        try {
            $updateProject->handle(
                $project,
                $request->validated(),
                $request->validated('member_ids') ?? []
            );
        } catch (ValidationException $exception) {
            return back()
                ->withInput()
                ->withErrors(
                    $exception->errors()
                );
        }

        return redirect()
            ->route(
                'projects.index'
            )
            ->with(
                'success',
                'Project updated successfully.'
            );
    }


    /**
     * Archive Project.
     */
    public function archive(
        Project $project,
        ArchiveProject $archiveProject
    ) {
        Gate::authorize(
            'archive',
            $project
        );

        /*
        |--------------------------------------------------------------------------
        | Project Must Be Completed
        |--------------------------------------------------------------------------
        */

        if ($project->status !== 'Completed') {
            return redirect()
                ->route(
                    'projects.index'
                )
                ->with(
                    'error',
                    'Only completed projects can be archived.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | All Tasks Must Be Done
        |--------------------------------------------------------------------------
        */

        if (
            $project->tasks()
                ->where(
                    'status',
                    '!=',
                    'Done'
                )
                ->exists()
        ) {
            return redirect()
                ->route(
                    'projects.index'
                )
                ->with(
                    'error',
                    'Project cannot be archived until all tasks are completed.'
                );
        }

        try {
            $archiveProject->handle(
                $project
            );

            return redirect()
                ->route(
                    'projects.index'
                )
                ->with(
                    'success',
                    'Project archived successfully.'
                );
        } catch (\Exception $exception) {
            return redirect()
                ->route(
                    'projects.index'
                )
                ->with(
                    'error',
                    $exception->getMessage()
                );
        }
    }


    /**
     * Restore Project.
     */
    public function restore(
        Project $project,
        RestoreProject $restoreProject
    ) {
        Gate::authorize(
            'restore',
            $project
        );

        try {
            $restoreProject->handle(
                $project
            );
        } catch (ValidationException $exception) {
            return redirect()
                ->route(
                    'projects.index'
                )
                ->with(
                    'error',
                    $exception->errors()['project'][0]
                        ?? 'Project could not be restored.'
                );
        }

        return redirect()
            ->route(
                'projects.index',
                [
                    'archived' => 1,
                ]
            )
            ->with(
                'success',
                'Project restored successfully.'
            );
    }


    /**
     * Delete Project.
     */
    public function destroy(
        Project $project,
        DeleteProject $deleteProject
    ) {
        Gate::authorize(
            'delete',
            $project
        );

        $deleted = $deleteProject->handle(
            $project
        );

        if (!$deleted) {
            return redirect()
                ->route(
                    'projects.index'
                )
                ->with(
                    'error',
                    'Project cannot be deleted because it has associated tasks.'
                );
        }

        return redirect()
            ->route(
                'projects.index'
            )
            ->with(
                'success',
                'Project deleted successfully.'
            );
    }
}
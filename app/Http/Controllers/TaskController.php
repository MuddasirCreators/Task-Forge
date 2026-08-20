<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Task;
use App\Models\Project;

use App\Actions\Tasks\CreateTask;
use App\Actions\Tasks\UpdateTask;
use App\Actions\Tasks\DeleteTask;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Get tasks according to the authenticated user's role.
     *
     * Admin:
     * - Can access all tasks.
     *
     * Manager:
     * - Can access tasks belonging to their own projects.
     *
     * Member:
     * - Can access only tasks assigned to themselves.
     */
    private function taskQuery()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Admin') {
            return Task::query();
        }

        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Manager') {
            $projectIds = Project::whereHas(
                'client',
                function ($query) use ($user) {
                    $query->where(
                        'created_by',
                        $user->id
                    );
                }
            )
                ->pluck('id');

            return Task::whereIn(
                'project_id',
                $projectIds
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Member') {
            return Task::where(
                'assigned_to',
                $user->id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        return Task::whereRaw(
            '1 = 0'
        );
    }


    /**
     * Global Tasks Dashboard.
     */
    public function allTasks(Request $request)
    {
        Gate::authorize(
            'viewAny',
            Task::class
        );

        $query = $this->taskQuery()
            ->with([
                'project.members',
                'assignee',
                'timeLogs.user',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim(
                $request->search
            );

            $query->where(
                function ($q) use ($search) {
                    $q->where(
                        'title',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Project Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('project')) {
            $query->where(
                'project_id',
                $request->project
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $tasks = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'tasks.dashboard',
            [
                'tasks' => $tasks,

                'projects' => $this->availableProjects(),

                'totalTasks' =>
                    (clone $this->taskQuery())
                    ->count(),

                'todoTasks' =>
                    (clone $this->taskQuery())
                    ->where(
                        'status',
                        'Todo'
                    )
                    ->count(),

                'progressTasks' =>
                    (clone $this->taskQuery())
                    ->where(
                        'status',
                        'In Progress'
                    )
                    ->count(),

                'doneTasks' =>
                    (clone $this->taskQuery())
                    ->where(
                        'status',
                        'Done'
                    )
                    ->count(),

                'overdueTasks' =>
                    (clone $this->taskQuery())
                    ->whereDate(
                        'due_date',
                        '<',
                        today()
                    )
                    ->where(
                        'status',
                        '!=',
                        'Done'
                    )
                    ->count(),
            ]
        );
    }


    /**
     * Available projects according to role.
     */
    private function availableProjects()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Admin') {
            return Project::with('members')
                ->orderBy('name')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Manager') {
            return Project::with('members')
                ->whereHas(
                    'client',
                    function ($query) use ($user) {
                        $query->where(
                            'created_by',
                            $user->id
                        );
                    }
                )
                ->orderBy('name')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        |
        | A member can see projects to which they
        | are assigned, even if they do not have
        | a task in that project yet.
        |
        */

        if ($user->role === 'Member') {
            return Project::with('members')
                ->whereHas(
                    'members',
                    function ($query) use ($user) {
                        $query->where(
                            'users.id',
                            $user->id
                        );
                    }
                )
                ->orderBy('name')
                ->get();
        }

        return collect();
    }


    /**
     * Display tasks for a project.
     */
    public function index(Project $project)
    {
        $tasks = $this->taskQuery()
            ->where(
                'project_id',
                $project->id
            )
            ->with([
                'project.members',
                'assignee',
                'timeLogs.user',
            ])
            ->latest()
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Prevent Unauthorized Users From Viewing
        | An Empty / Foreign Project
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->role === 'Member' &&
            !$tasks->total()
        ) {
            abort(
                403,
                'This action is unauthorized.'
            );
        }

        if (
            auth()->user()->role === 'Manager' &&
            (
                !$project->client ||
                $project->client->created_by !== auth()->id()
            )
        ) {
            abort(
                403,
                'This action is unauthorized.'
            );
        }

        return view(
            'tasks.index',
            compact(
                'project',
                'tasks'
            )
        );
    }


    /**
     * Show create task form.
     */
    public function create(Project $project)
    {
        Gate::authorize(
            'create',
            [
                Task::class,
                $project,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Load Members Assigned To This Project
        |--------------------------------------------------------------------------
        */

        $project->load(
            'members'
        );

        return view(
            'tasks.create',
            compact(
                'project'
            )
        );
    }


    /**
     * Store task.
     */
    public function store(
        StoreTaskRequest $request,
        Project $project,
        CreateTask $createTask
    ) {
        Gate::authorize(
            'create',
            [
                Task::class,
                $project,
            ]
        );

        try {
            $data = $request->validated();

            /*
            |--------------------------------------------------------------------------
            | Always Use Project From URL
            |--------------------------------------------------------------------------
            */

            $data['project_id'] = $project->id;

            /*
            |--------------------------------------------------------------------------
            | Create Task
            |--------------------------------------------------------------------------
            |
            | CreateTask is responsible for:
            |
            | - Business rules
            | - Database creation
            | - TaskCreated event
            |
            */

            $createTask->handle(
                $data
            );

            return redirect()
                ->route(
                    'projects.tasks.index',
                    $project
                )
                ->with(
                    'success',
                    'Task created successfully.'
                );
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        }
    }


    /**
     * Show task.
     */
    public function show(
        Project $project,
        Task $task
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ensure Task Belongs To Requested Project
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $task->project_id ===
            (int) $project->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Task Policy
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'view',
            $task
        );

        $task->load([
            'project.members',
            'assignee',
            'timeLogs.user',
        ]);

        return view(
            'tasks.show',
            compact(
                'project',
                'task'
            )
        );
    }


    /**
     * Show edit task form.
     */
    public function edit(
        Project $project,
        Task $task
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ensure Task Belongs To Requested Project
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $task->project_id ===
            (int) $project->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Task Policy
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'update',
            $task
        );

        $project->load(
            'members'
        );

        return view(
            'tasks.edit',
            compact(
                'project',
                'task'
            )
        );
    }


    /**
     * Update task.
     */
    public function update(
        UpdateTaskRequest $request,
        Project $project,
        Task $task,
        UpdateTask $updateTask
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ensure Task Belongs To Requested Project
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $task->project_id ===
            (int) $project->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Task Policy
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'update',
            $task
        );

        try {
            $data = $request->validated();

            /*
            |--------------------------------------------------------------------------
            | Never Trust project_id From Request
            |--------------------------------------------------------------------------
            */

            $data['project_id'] = $project->id;

            /*
            |--------------------------------------------------------------------------
            | Update Task
            |--------------------------------------------------------------------------
            |
            | UpdateTask is responsible for:
            |
            | - Business rules
            | - Assignment change detection
            | - Status change detection
            | - TaskAssigned event
            | - TaskStatusChanged event
            | - TaskUpdated event
            |
            */

            $updateTask->handle(
                $task,
                $data
            );

            return redirect()
                ->route(
                    'projects.tasks.index',
                    $project
                )
                ->with(
                    'success',
                    'Task updated successfully.'
                );
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        }
    }


    /**
     * Show delete task confirmation page.
     */
    public function delete(
        Project $project,
        Task $task
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ensure Task Belongs To Requested Project
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $task->project_id ===
            (int) $project->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Task Policy
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'delete',
            $task
        );

        return view(
            'tasks.delete',
            compact(
                'project',
                'task'
            )
        );
    }


    /**
     * Delete task.
     */
    public function destroy(
        Project $project,
        Task $task,
        DeleteTask $deleteTask
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ensure Task Belongs To Requested Project
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $task->project_id ===
            (int) $project->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Task Policy
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'delete',
            $task
        );

        try {
            /*
            |--------------------------------------------------------------------------
            | Delete Task
            |--------------------------------------------------------------------------
            |
            | DeleteTask is responsible for:
            |
            | - Time log deletion restriction
            | - Task deletion
            | - TaskDeleted event
            | - TaskDeletionFailed event
            |
            */

            $deleteTask->handle(
                $task
            );

            /*
            |--------------------------------------------------------------------------
            | Redirect To Global Tasks Page
            |--------------------------------------------------------------------------
            |
            | Important for Members:
            |
            | After deleting their last assigned task,
            | they may no longer have access to the project page.
            |
            */

            return redirect()
                ->route(
                    'tasks.index'
                )
                ->with(
                    'success',
                    'Task deleted successfully.'
                );
        } catch (Exception $e) {
            return back()
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        }
    }
}
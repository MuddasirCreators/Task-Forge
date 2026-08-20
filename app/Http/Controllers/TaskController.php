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
     * Get tasks according to authenticated user role.
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



        return Task::whereRaw('1 = 0');

    }





    /**
     * Get available projects for filters.
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

            return Project::query()
                ->latest()
                ->get();

        }





        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Manager') {


            return Project::query()

                ->whereHas(
                    'client',
                    function ($query) use ($user) {

                        $query->where(
                            'created_by',
                            $user->id
                        );

                    }
                )

                ->latest()

                ->get();

        }





        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Member') {


            return $user
                ->projects()
                ->latest()
                ->get();

        }



        return collect();

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
            ])

            ->withSum(
                'timeLogs',
                'minutes'
            );





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





        if ($request->filled('project')) {

            $query->where(
                'project_id',
                $request->project
            );

        }





        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }




        $tasks = $query

            ->latest()

            ->paginate(10)

            ->withQueryString();





        return view(
            'tasks.dashboard',
            [

                'tasks' => $tasks,


                'projects' =>
                    $this->availableProjects(),



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




}
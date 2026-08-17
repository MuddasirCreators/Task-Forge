<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Actions\Tasks\CreateTask;
use App\Actions\Tasks\UpdateTask;
use App\Actions\Tasks\DeleteTask;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;


class TaskController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Get Task Query According To Role
    |--------------------------------------------------------------------------
    */

    private function taskQuery()
    {

        $user = auth()->user();



        // Admin
        if($user->role === 'Admin')
        {

            return Task::query();

        }




        // Manager
        if($user->role === 'Manager')
        {


            $projectIds = Project::where(
                'created_by',
                $user->id
            )
            ->pluck('id');



            return Task::whereIn(
                'project_id',
                $projectIds
            );


        }




        // Member

        return Task::where(
            'assigned_to',
            $user->id
        );


    }






    /**
     * Global Tasks Dashboard
     */
    public function allTasks(Request $request)
    {


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

        if($request->filled('search'))
        {


            $search = trim($request->search);


            $query->where(function($q) use($search){

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

            });


        }





        /*
        |--------------------------------------------------------------------------
        | Project Filter
        |--------------------------------------------------------------------------
        */


        if($request->filled('project'))
        {

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


        if($request->filled('status'))
        {

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

            'tasks'=>$tasks,



            'projects'=> $this->availableProjects(),



            'totalTasks'=>
                (clone $this->taskQuery())
                ->count(),



            'todoTasks'=>
                (clone $this->taskQuery())
                ->where(
                    'status',
                    'Todo'
                )
                ->count(),




            'progressTasks'=>
                (clone $this->taskQuery())
                ->where(
                    'status',
                    'In Progress'
                )
                ->count(),




            'doneTasks'=>
                (clone $this->taskQuery())
                ->where(
                    'status',
                    'Done'
                )
                ->count(),





            'overdueTasks'=>
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







    /*
    |--------------------------------------------------------------------------
    | Available Projects According To Role
    |--------------------------------------------------------------------------
    */

    private function availableProjects()
    {

        $user = auth()->user();



        if($user->role === 'Admin')
        {

            return Project::with('members')
                ->orderBy('name')
                ->get();

        }



        if($user->role === 'Manager')
        {


            return Project::with('members')
                ->where(
                    'created_by',
                    $user->id
                )
                ->orderBy('name')
                ->get();


        }



        return Project::with('members')
            ->whereHas(
                'tasks',
                function($q){

                    $q->where(
                        'assigned_to',
                        auth()->id()
                    );

                }
            )
            ->orderBy('name')
            ->get();


    }








    /**
     * Project Tasks
     */
    public function index(Project $project)
    {


        $this->checkProjectAccess($project);



        $tasks = $this->taskQuery()
            ->where(
                'project_id',
                $project->id
            )
            ->with([

                'project.members',

                'assignee',

                'timeLogs.user'

            ])
            ->latest()
            ->paginate(10);



        return view(
            'tasks.index',
            compact(
                'project',
                'tasks'
            )
        );


    }








    /**
     * Check Project Permission
     */

    private function checkProjectAccess(Project $project)
    {

        $user = auth()->user();



        if($user->role === 'Admin')
        {
            return;
        }



        if($user->role === 'Manager')
        {

            abort_unless(
                $project->created_by == $user->id,
                403
            );

        }



        else
        {

            abort_unless(

                $project->members()
                ->where(
                    'users.id',
                    $user->id
                )
                ->exists(),

                403
            );

        }


    }






    /**
     * Create Task
     */

    public function create(Project $project)
    {

        $this->checkProjectAccess($project);



        $project->load('members');


        return view(
            'tasks.create',
            compact('project')
        );


    }







    /**
     * Store Task
     */

    public function store(
        StoreTaskRequest $request,
        Project $project,
        CreateTask $createTask
    )
    {


        $this->checkProjectAccess($project);



        try{


            $data = $request->validated();


            $data['project_id']=$project->id;



            $createTask->handle($data);



            return redirect()

                ->route(
                    'projects.tasks.index',
                    $project
                )

                ->with(
                    'success',
                    'Task created successfully.'
                );


        }
        catch(Exception $e)
        {


            return back()

            ->withInput()

            ->withErrors([
                'error'=>$e->getMessage()
            ]);


        }


    }






    /**
     * Show Task
     */

    public function show(
        Project $project,
        Task $task
    )
    {


        $this->checkProjectAccess($project);



        abort_unless(
            $task->project_id == $project->id,
            404
        );



        $task->load([
            'project.members',
            'assignee',
            'timeLogs.user'
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
     * Edit Task
     */

    public function edit(
        Project $project,
        Task $task
    )
    {


        $this->checkProjectAccess($project);



        abort_unless(
            $task->project_id == $project->id,
            404
        );



        $project->load('members');


        return view(
            'tasks.edit',
            compact(
                'project',
                'task'
            )
        );


    }








    /**
     * Update Task
     */

    public function update(
        UpdateTaskRequest $request,
        Project $project,
        Task $task,
        UpdateTask $updateTask
    )
    {


        $this->checkProjectAccess($project);



        try{


            $data=$request->validated();


            $data['project_id']=$project->id;



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


        }
        catch(Exception $e)
        {

            return back()
            ->withInput()
            ->withErrors([
                'error'=>$e->getMessage()
            ]);

        }


    }







    /**
     * Delete Task
     */

    public function destroy(
        Project $project,
        Task $task,
        DeleteTask $deleteTask
    )
    {


        $this->checkProjectAccess($project);



        $deleteTask->handle($task);



        return redirect()

            ->route(
                'projects.tasks.index',
                $project
            )

            ->with(
                'success',
                'Task deleted successfully.'
            );


    }


}
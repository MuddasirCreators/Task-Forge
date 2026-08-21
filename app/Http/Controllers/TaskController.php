<?php

namespace App\Http\Controllers;


use App\Actions\Tasks\CreateTask;
use App\Actions\Tasks\DeleteTask;
use App\Actions\Tasks\GetAvailableProjects;
use App\Actions\Tasks\GetTaskDetails;
use App\Actions\Tasks\GetTasks;
use App\Actions\Tasks\UpdateTask;
use App\Actions\Tasks\VerifyTaskProject;


use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;


use App\Models\Project;
use App\Models\Task;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;



class TaskController extends Controller
{


    public function allTasks(
        Request $request,
        GetTasks $getTasks
    ) {

        Gate::authorize(
            'viewAny',
            Task::class
        );


        return view(
            'tasks.dashboard',
            $getTasks->handle(
                auth()->user(),
                $request
            )
        );
    }





    public function index(
        Project $project,
        GetTasks $getTasks
    ) {


        Gate::authorize(
            'viewProject',
            [
                Task::class,
                $project
            ]
        );


        return view(
            'tasks.index',
            array_merge(
                $getTasks->handle(
                    auth()->user(),
                    request(),
                    $project
                ),
                [
                    'project'=>$project
                ]
            )
        );
    }





    public function create(
        Project $project,
        GetAvailableProjects $getAvailableProjects
    ) {


        Gate::authorize(
            'create',
            [
                Task::class,
                $project
            ]
        );


        return view(
            'tasks.create',
            [
                'project'=>$project,

                'projects'=>$getAvailableProjects->handle(
                    auth()->user()
                )
            ]
        );
    }





    public function store(
        StoreTaskRequest $request,
        Project $project,
        CreateTask $createTask
    ) {


        Gate::authorize(
            'create',
            [
                Task::class,
                $project
            ]
        );


        $createTask->handle(
            array_merge(
                $request->validated(),
                [
                    'project_id'=>$project->id
                ]
            )
        );


        return redirect()
            ->route(
                'tasks.index',
                $project
            )
            ->with(
                'success',
                'Task created successfully.'
            );
    }





    public function show(
        Project $project,
        Task $task,
        VerifyTaskProject $verifyTaskProject,
        GetTaskDetails $getTaskDetails
    ) {


        $verifyTaskProject->handle(
            $project,
            $task
        );


        Gate::authorize(
            'view',
            $task
        );


        $task = $getTaskDetails->handle(
            $task
        );


        return view(
            'tasks.show',
            compact(
                'project',
                'task'
            )
        );
    }





    public function edit(
        Project $project,
        Task $task,
        VerifyTaskProject $verifyTaskProject
    ) {


        $verifyTaskProject->handle(
            $project,
            $task
        );


        Gate::authorize(
            'update',
            $task
        );


        return view(
            'tasks.edit',
            compact(
                'project',
                'task'
            )
        );
    }





    public function update(
        UpdateTaskRequest $request,
        Project $project,
        Task $task,
        UpdateTask $updateTask,
        VerifyTaskProject $verifyTaskProject
    ) {


        $verifyTaskProject->handle(
            $project,
            $task
        );


        Gate::authorize(
            'update',
            $task
        );


        try {

            $updateTask->handle(
                $task,
                $request->validated()
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
                'tasks.index',
                $project
            )
            ->with(
                'success',
                'Task updated successfully.'
            );
    }





    public function destroy(
        Project $project,
        Task $task,
        DeleteTask $deleteTask,
        VerifyTaskProject $verifyTaskProject
    ) {


        $verifyTaskProject->handle(
            $project,
            $task
        );


        Gate::authorize(
            'delete',
            $task
        );


        try {

            $deleteTask->handle(
                $task
            );


        } catch (ValidationException $exception) {


            return back()
                ->withErrors(
                    $exception->errors()
                );
        }



        return redirect()
            ->route(
                'tasks.index',
                $project
            )
            ->with(
                'success',
                'Task deleted successfully.'
            );
    }


}
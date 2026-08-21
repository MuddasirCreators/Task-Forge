<?php

namespace App\Actions\Tasks;


use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;



class GetTasks
{


    /**
     * Get tasks according to user role.
     */
    public function handle(
        User $user,
        Request $request
    ): array {


        $query = $this->taskQuery($user);



        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );


            $query->where(function ($q) use ($search) {

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




        $tasks = $query
            ->with([
                'project',
                'assignee',
                'timeLogs.user'
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();




        return [

            'tasks'=>$tasks,


            'projects'=>$this->availableProjects(
                $user
            ),



            'totalTasks'=>

                (clone $this->taskQuery($user))
                ->count(),



            'todoTasks'=>

                (clone $this->taskQuery($user))
                ->where(
                    'status',
                    'Todo'
                )
                ->count(),



            'progressTasks'=>

                (clone $this->taskQuery($user))
                ->where(
                    'status',
                    'In Progress'
                )
                ->count(),



            'doneTasks'=>

                (clone $this->taskQuery($user))
                ->where(
                    'status',
                    'Done'
                )
                ->count(),



            'overdueTasks'=>

                (clone $this->taskQuery($user))
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


        ];

    }






    /**
     * Task visibility rules.
     */
    private function taskQuery(User $user)
    {


        if ($user->role === 'Admin') {

            return Task::query();

        }




        if ($user->role === 'Manager') {


            $projects = Project::whereHas(
                'client',
                function($query) use ($user){

                    $query->where(
                        'created_by',
                        $user->id
                    );

                }
            )
            ->pluck('id');



            return Task::whereIn(
                'project_id',
                $projects
            );

        }





        if ($user->role === 'Member') {


            return Task::where(
                'assigned_to',
                $user->id
            );


        }



        return Task::whereRaw(
            '1=0'
        );

    }







    /**
     * Projects for filter dropdown.
     */
    private function availableProjects(User $user)
    {


        if ($user->role === 'Admin') {


            return Project::orderBy(
                'name'
            )
            ->get();

        }




        if ($user->role === 'Manager') {


            return Project::whereHas(
                'client',
                function($query) use ($user){

                    $query->where(
                        'created_by',
                        $user->id
                    );

                }
            )
            ->orderBy('name')
            ->get();

        }





        if ($user->role === 'Member') {


            return Project::whereHas(
                'members',
                function($query) use ($user){

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



}
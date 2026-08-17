<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;

class DashboardController extends Controller
{

    /**
     * Display Dashboard
     */
    public function index()
    {

        $user = auth()->user();



        /*
        |--------------------------------------------------------------------------
        | Base Queries According To Role
        |--------------------------------------------------------------------------
        */


        // Admin
        if($user->role === 'Admin'){


            $projectsQuery = Project::query();

            $tasksQuery = Task::query();

            $clientsQuery = Client::query();

            $timeLogsQuery = TimeLog::query();


        }


        // Manager
        elseif($user->role === 'Manager'){


            $projectsQuery = Project::where(
                'created_by',
                $user->id
            );


            $projectIds = $projectsQuery->pluck('id');



            $tasksQuery = Task::whereIn(
                'project_id',
                $projectIds
            );


            $clientsQuery = Client::where(
                'created_by',
                $user->id
            );



            $taskIds = $tasksQuery->pluck('id');


            $timeLogsQuery = TimeLog::whereIn(
                'task_id',
                $taskIds
            );


        }



        // Member
        else{


            $projectIds = $user
                ->projects()
                ->pluck('projects.id');



            $projectsQuery = Project::whereIn(
                'id',
                $projectIds
            );



            $tasksQuery = Task::where(
                'assigned_to',
                $user->id
            );



            $clientsQuery = Client::whereIn(
                'id',
                Project::whereIn(
                    'id',
                    $projectIds
                )
                ->pluck('client_id')
            );



            $taskIds = $tasksQuery->pluck('id');



            $timeLogsQuery = TimeLog::where(
                'user_id',
                $user->id
            );


        }





        /*
        |--------------------------------------------------------------------------
        | Main Statistics
        |--------------------------------------------------------------------------
        */


        $totalClients = $clientsQuery->count();


        $totalProjects = $projectsQuery->count();


        $totalTasks = $tasksQuery->count();


        $totalTimeLogs = $timeLogsQuery->count();






        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */


        if($user->role === 'Admin'){


            $totalAdmins = User::where(
                'role',
                'Admin'
            )->count();


            $totalManagers = User::where(
                'role',
                'Manager'
            )->count();


            $totalMembers = User::where(
                'role',
                'Member'
            )->count();


        }
        else{


            $totalAdmins = 0;

            $totalManagers = 0;

            $totalMembers = 0;


        }





        /*
        |--------------------------------------------------------------------------
        | Task Status Statistics
        |--------------------------------------------------------------------------
        */


        $todoTasks = (clone $tasksQuery)
            ->where('status','Todo')
            ->count();



        $progressTasks = (clone $tasksQuery)
            ->where('status','In Progress')
            ->count();



        $doneTasks = (clone $tasksQuery)
            ->where('status','Done')
            ->count();



        $overdueTasks = (clone $tasksQuery)
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
            ->count();






        /*
        |--------------------------------------------------------------------------
        | Priority Statistics
        |--------------------------------------------------------------------------
        */


        $highPriorityTasks = (clone $tasksQuery)
            ->where(
                'priority',
                'High'
            )
            ->count();



        $mediumPriorityTasks = (clone $tasksQuery)
            ->where(
                'priority',
                'Medium'
            )
            ->count();



        $lowPriorityTasks = (clone $tasksQuery)
            ->where(
                'priority',
                'Low'
            )
            ->count();






        /*
        |--------------------------------------------------------------------------
        | Last 6 Months Chart
        |--------------------------------------------------------------------------
        */


        $monthlyLabels = [];

        $monthlyTaskCounts = [];



        for($i = 5; $i >=0; $i--)
        {

            $month = now()->subMonths($i);



            $monthlyLabels[] = $month->format('M Y');



            $monthlyTaskCounts[] = (clone $tasksQuery)
                ->whereYear(
                    'created_at',
                    $month->year
                )
                ->whereMonth(
                    'created_at',
                    $month->month
                )
                ->count();

        }







        /*
        |--------------------------------------------------------------------------
        | Recent Tasks
        |--------------------------------------------------------------------------
        */


        $recentTasks = (clone $tasksQuery)
            ->with('project')
            ->latest()
            ->take(10)
            ->get();







        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */


        $currentUser = auth()->user();






        return view(
            'dashboard.index',
            compact(

                'totalClients',

                'totalProjects',

                'totalTasks',

                'totalTimeLogs',


                'totalAdmins',

                'totalManagers',

                'totalMembers',


                'todoTasks',

                'progressTasks',

                'doneTasks',

                'overdueTasks',


                'highPriorityTasks',

                'mediumPriorityTasks',

                'lowPriorityTasks',


                'monthlyLabels',

                'monthlyTaskCounts',


                'recentTasks',


                'currentUser'

            )
        );


    }

}
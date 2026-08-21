<?php

namespace App\Actions\Dashboard;


use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;
use App\Models\AuditLog;



class GetDashboardData
{


    /**
     * Generate dashboard data according to user role.
     */
    public function handle(
        User $user
    ): array {


        /*
        |--------------------------------------------------------------------------
        | Role Based Queries
        |--------------------------------------------------------------------------
        */


        if ($user->role === 'Admin') {


            $projectsQuery = Project::query();

            $tasksQuery = Task::query();

            $clientsQuery = Client::query();

            $timeLogsQuery = TimeLog::query();


        }

        elseif ($user->role === 'Manager') {


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


            $timeLogsQuery = TimeLog::whereIn(
                'task_id',
                $tasksQuery->pluck('id')
            );


        }

        else {


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


            $timeLogsQuery = TimeLog::where(
                'user_id',
                $user->id
            );


        }




        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */


        $totalAdmins = 0;
        $totalManagers = 0;
        $totalMembers = 0;



        if ($user->role === 'Admin') {


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




        /*
        |--------------------------------------------------------------------------
        | Task Statistics
        |--------------------------------------------------------------------------
        */


        $todoTasks = (clone $tasksQuery)
            ->where(
                'status',
                'Todo'
            )
            ->count();



        $progressTasks = (clone $tasksQuery)
            ->where(
                'status',
                'In Progress'
            )
            ->count();



        $doneTasks = (clone $tasksQuery)
            ->where(
                'status',
                'Done'
            )
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
        | Monthly Chart
        |--------------------------------------------------------------------------
        */


        $monthlyLabels = [];

        $monthlyTaskCounts = [];



        for ($i = 5; $i >= 0; $i--) {


            $month = now()->subMonths($i);



            $monthlyLabels[] =
                $month->format('M Y');



            $monthlyTaskCounts[] =
                (clone $tasksQuery)
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
        | Recent Audit Logs
        |--------------------------------------------------------------------------
        */


        if ($user->role === 'Admin') {


            $recentAuditLogs = AuditLog::with('user')
                ->latest()
                ->take(5)
                ->get();


        }

        elseif ($user->role === 'Manager') {


            $projectIds = Project::where(
                'created_by',
                $user->id
            )
            ->pluck('id');



            $taskIds = Task::whereIn(
                'project_id',
                $projectIds
            )
            ->pluck('id');



            $recentAuditLogs = AuditLog::with('user')
                ->where(function ($query) use (
                    $user,
                    $projectIds,
                    $taskIds
                ) {


                    $query->where(
                        'user_id',
                        $user->id
                    )

                    ->orWhere(function ($q) use ($projectIds) {

                        $q->where(
                            'auditable_type',
                            Project::class
                        )
                        ->whereIn(
                            'auditable_id',
                            $projectIds
                        );

                    })

                    ->orWhere(function ($q) use ($taskIds) {

                        $q->where(
                            'auditable_type',
                            Task::class
                        )
                        ->whereIn(
                            'auditable_id',
                            $taskIds
                        );

                    });


                })
                ->latest()
                ->take(5)
                ->get();


        }

        else {


            $recentAuditLogs = AuditLog::with('user')
                ->where(
                    'user_id',
                    $user->id
                )
                ->latest()
                ->take(5)
                ->get();


        }






        return [


            'totalClients' =>
                $clientsQuery->count(),


            'totalProjects' =>
                $projectsQuery->count(),


            'totalTasks' =>
                $tasksQuery->count(),


            'totalTimeLogs' =>
                $timeLogsQuery->count(),




            'totalAdmins' =>
                $totalAdmins,


            'totalManagers' =>
                $totalManagers,


            'totalMembers' =>
                $totalMembers,




            'todoTasks' =>
                $todoTasks,


            'progressTasks' =>
                $progressTasks,


            'doneTasks' =>
                $doneTasks,


            'overdueTasks' =>
                $overdueTasks,




            'highPriorityTasks' =>
                $highPriorityTasks,


            'mediumPriorityTasks' =>
                $mediumPriorityTasks,


            'lowPriorityTasks' =>
                $lowPriorityTasks,




            'monthlyLabels' =>
                $monthlyLabels,


            'monthlyTaskCounts' =>
                $monthlyTaskCounts,




            'recentTasks' =>
                $recentTasks,


            'recentAuditLogs' =>
                $recentAuditLogs,



            'currentUser' =>
                $user,


        ];

    }

}
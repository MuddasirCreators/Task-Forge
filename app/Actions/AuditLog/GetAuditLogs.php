<?php

namespace App\Actions\AuditLog;


use App\Models\AuditLog;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;



class GetAuditLogs
{


    /**
     * Get audit logs according to user role.
     */
    public function handle(User $user)
    {


        $query = AuditLog::with('user')
            ->latest();



        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Admin') {


            return $query->paginate(20);


        }





        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Manager') {


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



            $timeLogIds = TimeLog::whereIn(
                'task_id',
                $taskIds
            )
            ->pluck('id');



            return $query
                ->where(function ($q) use (
                    $user,
                    $projectIds,
                    $taskIds,
                    $timeLogIds
                ) {


                    // Manager own actions

                    $q->where(
                        'user_id',
                        $user->id
                    );



                    // Projects

                    $q->orWhere(function ($sub) use ($projectIds) {


                        $sub->where(
                            'auditable_type',
                            Project::class
                        )
                        ->whereIn(
                            'auditable_id',
                            $projectIds
                        );


                    });



                    // Tasks

                    $q->orWhere(function ($sub) use ($taskIds) {


                        $sub->where(
                            'auditable_type',
                            Task::class
                        )
                        ->whereIn(
                            'auditable_id',
                            $taskIds
                        );


                    });



                    // Time Logs

                    $q->orWhere(function ($sub) use ($timeLogIds) {


                        $sub->where(
                            'auditable_type',
                            TimeLog::class
                        )
                        ->whereIn(
                            'auditable_id',
                            $timeLogIds
                        );


                    });



                })
                ->paginate(20);



        }




        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

        return $query
            ->where(
                'user_id',
                $user->id
            )
            ->paginate(20);



    }


}
<?php

namespace App\Actions\Team;


use App\Models\User;
use App\Models\Task;



class GetTeamMemberDetails
{


    public function handle(
        User $user
    ): array {


        $tasks = Task::where(
                'assigned_to',
                $user->id
            )
            ->with([
                'project',
                'timeLogs'
            ])
            ->latest()
            ->get();




        $totalLogMinutes = $tasks->sum(function($task){

            return $task->timeLogs
                ->sum('minutes');

        });




        return [


            'user'=>$user,


            'tasks'=>$tasks,


            'totalTasks'=>$tasks->count(),


            'todoTasks'=>$tasks
                ->where('status','Todo')
                ->count(),



            'progressTasks'=>$tasks
                ->where('status','In Progress')
                ->count(),



            'completedTasks'=>$tasks
                ->where('status','Done')
                ->count(),



            'overdueTasks'=>$tasks
                ->filter(function($task){

                    return $task->due_date
                        &&
                        $task->due_date->isPast()
                        &&
                        $task->status !== 'Done';

                })
                ->count(),



            'totalLogMinutes'=>$totalLogMinutes,


            'totalLogHours'=>intdiv(
                $totalLogMinutes,
                60
            ),


            'remainingMinutes'=>$totalLogMinutes % 60,


        ];


    }


}
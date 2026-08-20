<?php

namespace App\Jobs;

use App\Models\Task;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOverdueTask implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    /**
     * The task that is being processed.
     */
    public Task $task;


    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Refresh Task
        |--------------------------------------------------------------------------
        |
        | The task may have been changed after the job was dispatched.
        | Refresh it before processing.
        |
        */

        $this->task->refresh();


        /*
        |--------------------------------------------------------------------------
        | Check Task Due Date
        |--------------------------------------------------------------------------
        |
        | Do not process the task if it does not have a due date
        | or its due date is still in the future.
        |
        */

        if (!$this->task->due_date) {
            return;
        }


        if ($this->task->due_date->isFuture()) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Do Not Notify Completed Tasks
        |--------------------------------------------------------------------------
        */

        if ($this->task->status === 'Done') {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Project
        |--------------------------------------------------------------------------
        */

        $project = $this->task->project;


        /*
        |--------------------------------------------------------------------------
        | Project Must Exist
        |--------------------------------------------------------------------------
        */

        if (!$project) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Project Manager / Creator
        |--------------------------------------------------------------------------
        |
        | Your Project model uses:
        |
        | created_by -> users.id
        |
        | through the creator() relationship.
        |
        */

        $manager = $project->creator;


        /*
        |--------------------------------------------------------------------------
        | Manager Must Exist
        |--------------------------------------------------------------------------
        */

        if (!$manager) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Send Overdue Notification
        |--------------------------------------------------------------------------
        |
        | The notification is sent to the Project Manager,
        | not directly to the Task Assignee.
        |
        */

        $manager->notify(
            new TaskOverdueNotification(
                $this->task
            )
        );
    }
}
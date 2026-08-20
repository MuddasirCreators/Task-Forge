<?php

namespace App\Console\Commands;

use App\Jobs\ProcessOverdueTask;
use App\Models\Task;
use Illuminate\Console\Command;

class SendOverdueTaskNotifications extends Command
{
    /**
     * Console command signature.
     */
    protected $signature = 'tasks:notify-overdue';


    /**
     * Console command description.
     */
    protected $description = 'Dispatch jobs for overdue tasks';


    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        /*
        |--------------------------------------------------------------------------
        | Find Overdue Tasks
        |--------------------------------------------------------------------------
        |
        | A task is considered overdue when:
        |
        | 1. It has a due date.
        | 2. The due date is in the past.
        | 3. The task status is not Done.
        |
        */

        $overdueTasks = Task::query()
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->where('status', '!=', 'Done')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dispatch Overdue Task Jobs
        |--------------------------------------------------------------------------
        */

        $count = 0;


        foreach ($overdueTasks as $task) {

            ProcessOverdueTask::dispatch($task);

            $count++;
        }


        /*
        |--------------------------------------------------------------------------
        | Console Output
        |--------------------------------------------------------------------------
        */

        $this->info(
            'Overdue task jobs dispatched: ' . $count
        );


        return self::SUCCESS;
    }
}
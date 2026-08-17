<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Console\Command;

class SendOverdueTaskNotifications extends Command
{
    protected $signature = 'tasks:notify-overdue';
    protected $description = 'Send notifications for overdue tasks';

    public function handle()
    {
        $overdueTasks = Task::with('assignee')
            ->where('due_date', '<', now())
            ->where('status', '!=', 'Done')
            ->get();

        $count = 0;

        foreach ($overdueTasks as $task) {
            if ($task->assignee) {
                $task->assignee->notify(new TaskOverdueNotification($task));
                $count++;
            }
        }

        $this->info('Overdue notifications sent: ' . $count);
    }
}
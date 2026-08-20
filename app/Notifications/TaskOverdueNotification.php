<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;


    /**
     * The overdue task.
     */
    public Task $task;


    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }


    /**
     * Notification Channels
     */
    public function via($notifiable): array
    {
        return [
            'database',
            'mail',
        ];
    }


    /**
     * Database Notification
     */
    public function toArray($notifiable): array
    {
        return [

            'type' => 'task_overdue',

            'title' => 'Task Overdue',

            'message' =>
                'Task "' . $this->task->title . '" is overdue.',

            'url' => route(
                'projects.tasks.show',
                [
                    $this->task->project_id,
                    $this->task->id,
                ]
            ),

            'icon' => 'bi-exclamation-triangle',

        ];
    }


    /**
     * Email Notification
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)

            ->subject(
                'Task Overdue Reminder - TaskForge'
            )

            ->greeting(
                'Hello ' . $notifiable->name
            )

            ->line(
                'A task in your project is overdue.'
            )

            ->line(
                'Task Name: ' . $this->task->title
            )

            ->line(
                'Project: ' . $this->task->project->name
            )

            ->line(
                'Due Date: ' . $this->task->due_date
            )

            ->line(
                'Current Status: ' . $this->task->status
            )

            ->action(
                'View Task',
                route(
                    'projects.tasks.show',
                    [
                        $this->task->project_id,
                        $this->task->id,
                    ]
                )
            )

            ->line(
                'Please review this overdue task and take the necessary action.'
            )

            ->line(
                'TaskForge Project Management System'
            );
    }
}
<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;


class ProjectAssignedNotification extends Notification
{
    use Queueable;


    public Project $project;



    /**
     * Create Notification
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }





    /**
     * Notification Channels
     */
    public function via(object $notifiable): array
    {
        return [

            'database',

            'mail'

        ];
    }





    /**
     * Database Notification
     */
    public function toArray(object $notifiable): array
    {

        return [

            'type'    => 'project_assigned',

            'title'   => 'New Project Assigned',

            'message' => 'You have been assigned to project: '
                        .$this->project->name,


            'url'     => route(
                'projects.show',
                $this->project->id
            ),


            'icon'    => 'bi-folder-plus',

        ];

    }





    /**
     * Email Notification
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)

            ->subject(
                'New Project Assigned - TaskForge'
            )


            ->greeting(
                'Hello '.$notifiable->name
            )


            ->line(
                'You have been assigned a new project.'
            )


            ->line(
                'Project Name: '.$this->project->name
            )


            ->line(
                'Project Status: '.$this->project->status
            )


            ->line(
                'Start Date: '.$this->project->start_date
            )


            ->line(
                'Due Date: '.$this->project->due_date
            )


            ->action(
                'View Project',
                route(
                    'projects.show',
                    $this->project->id
                )
            )


            ->line(
                'Please check your project details in TaskForge.'
            )


            ->line(
                'Thank you for using TaskForge.'
            );

    }



}
<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view any tasks.
     */
    public function viewAny(User $user): bool
    {
        return in_array(
            $user->role,
            [
                'Admin',
                'Manager',
                'Member',
            ],
            true
        );
    }



    /**
     * View a task.
     */
    public function view(
        User $user,
        Task $task
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Admin') {
            return true;
        }



        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        |
        | Manager can view tasks of projects
        | belonging to their own clients.
        |
        */

        if ($user->role === 'Manager') {

            return $task->project
                &&
                $task->project->client
                &&
                (int) $task->project->client->created_by
                ===
                (int) $user->id;
        }



        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        |
        | Member must:
        | 1. Be assigned to the task
        | 2. Belong to the project
        |
        */

        if ($user->role === 'Member') {

            return

                (int) $task->assigned_to
                ===
                (int) $user->id

                &&

                $task->project
                    ->members()
                    ->where(
                        'users.id',
                        $user->id
                    )
                    ->exists();
        }



        return false;
    }




    /**
     * View tasks inside a project.
     */
    public function viewProject(
        User $user,
        Project $project
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }



        if ($user->role === 'Manager') {

            return $project->client
                &&
                (int) $project->client->created_by
                ===
                (int) $user->id;
        }



        if ($user->role === 'Member') {

            return $project
                ->members()
                ->where(
                    'users.id',
                    $user->id
                )
                ->exists();
        }



        return false;
    }




    /**
     * Create Task.
     */
    public function create(
        User $user,
        Project $project
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }



        if ($user->role === 'Manager') {

            return $project->client
                &&
                (int) $project->client->created_by
                ===
                (int) $user->id;
        }



        if ($user->role === 'Member') {

            return $project
                ->members()
                ->where(
                    'users.id',
                    $user->id
                )
                ->exists();
        }



        return false;
    }




    /**
     * Update Task.
     */
    public function update(
        User $user,
        Task $task
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }



        if ($user->role === 'Manager') {

            return $task->project
                &&
                $task->project->client
                &&
                (int) $task->project->client->created_by
                ===
                (int) $user->id;
        }



        if ($user->role === 'Member') {

            return

                (int) $task->assigned_to
                ===
                (int) $user->id

                &&

                $task->project
                    ->members()
                    ->where(
                        'users.id',
                        $user->id
                    )
                    ->exists();
        }



        return false;
    }




    /**
     * Delete Task.
     */
    public function delete(
        User $user,
        Task $task
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }



        if ($user->role === 'Manager') {

            return $task->project
                &&
                $task->project->client
                &&
                (int) $task->project->client->created_by
                ===
                (int) $user->id;
        }



        if ($user->role === 'Member') {

            return

                (int) $task->assigned_to
                ===
                (int) $user->id

                &&

                $task->project
                    ->members()
                    ->where(
                        'users.id',
                        $user->id
                    )
                    ->exists();
        }



        return false;
    }
}
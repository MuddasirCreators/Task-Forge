<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;

class TimeLogPolicy
{
    /**
     * Determine whether the user can view any time logs.
     *
     * Admin:
     * - Can view all time logs.
     *
     * Manager:
     * - Can view time logs belonging to their own projects.
     *
     * Member:
     * - Can view their own time logs.
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
     * Determine whether the user can view a specific time log.
     *
     * Admin:
     * - Can view every time log.
     *
     * Manager:
     * - Can view time logs for projects belonging
     *   to clients created by that manager.
     *
     * Member:
     * - Can view only their own time logs.
     */
    public function view(
        User $user,
        TimeLog $timeLog
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
        */

        if ($user->role === 'Manager') {

            return $timeLog->task
                && $timeLog->task->project
                && $timeLog->task->project->client
                && (int) $timeLog->task->project->client->created_by === (int) $user->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Member') {

            return (int) $timeLog->user_id === (int) $user->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        return false;
    }


    /**
     * Determine whether the user can create a time log
     * for the specified task.
     *
     * Admin:
     * - Can create time logs for any task.
     *
     * Manager:
     * - Can create time logs for projects belonging
     *   to clients created by that manager.
     *
     * Member:
     * - Can create time logs only for tasks inside
     *   projects to which the member is assigned.
     */
    public function create(
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
        */

        if ($user->role === 'Manager') {

            return $task->project
                && $task->project->client
                && (int) $task->project->client->created_by === (int) $user->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Member') {

            if (!$task->project) {
                return false;
            }

            return $task->project
                ->members()
                ->where('users.id', $user->id)
                ->exists();
        }


        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        return false;
    }


    /**
     * Determine whether the user can update a time log.
     *
     * Admin:
     * - Can update every time log.
     *
     * Manager:
     * - Can update time logs belonging to their own projects.
     *
     * Member:
     * - Can update only their own time logs.
     * - The task must belong to a project to which
     *   the member is assigned.
     */
    public function update(
        User $user,
        TimeLog $timeLog
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
        */

        if ($user->role === 'Manager') {

            return $timeLog->task
                && $timeLog->task->project
                && $timeLog->task->project->client
                && (int) $timeLog->task->project->client->created_by === (int) $user->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Member') {

            /*
            |------------------------------------------------------------------
            | Member can only edit their own time log
            |------------------------------------------------------------------
            */

            if ((int) $timeLog->user_id !== (int) $user->id) {
                return false;
            }


            /*
            |------------------------------------------------------------------
            | Time log must have a valid task and project
            |------------------------------------------------------------------
            */

            if (!$timeLog->task || !$timeLog->task->project) {
                return false;
            }


            /*
            |------------------------------------------------------------------
            | Member must belong to the project
            |------------------------------------------------------------------
            */

            return $timeLog->task->project
                ->members()
                ->where('users.id', $user->id)
                ->exists();
        }


        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        return false;
    }


    /**
     * Determine whether the user can delete a time log.
     *
     * Admin:
     * - Can delete every time log.
     *
     * Manager:
     * - Can delete time logs belonging to their own projects.
     *
     * Member:
     * - Can delete only their own time logs.
     * - The task must belong to a project to which
     *   the member is assigned.
     */
    public function delete(
        User $user,
        TimeLog $timeLog
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
        */

        if ($user->role === 'Manager') {

            return $timeLog->task
                && $timeLog->task->project
                && $timeLog->task->project->client
                && (int) $timeLog->task->project->client->created_by === (int) $user->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'Member') {

            /*
            |------------------------------------------------------------------
            | Member can only delete their own time log
            |------------------------------------------------------------------
            */

            if ((int) $timeLog->user_id !== (int) $user->id) {
                return false;
            }


            /*
            |------------------------------------------------------------------
            | Time log must have a valid task and project
            |------------------------------------------------------------------
            */

            if (!$timeLog->task || !$timeLog->task->project) {
                return false;
            }


            /*
            |------------------------------------------------------------------
            | Member must belong to the project
            |------------------------------------------------------------------
            */

            return $timeLog->task->project
                ->members()
                ->where('users.id', $user->id)
                ->exists();
        }


        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        return false;
    }
}
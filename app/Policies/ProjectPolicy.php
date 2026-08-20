<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any projects.
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
     * Determine whether the user can view a project.
     */
    public function view(
        User $user,
        Project $project
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }


        if ($user->role === 'Manager') {

            return $this->isOwnerManager(
                $user,
                $project
            );
        }


        if ($user->role === 'Member') {

            return $this->isProjectMember(
                $user,
                $project
            );
        }


        return false;
    }



    /**
     * Determine whether the user can create projects.
     */
    public function create(User $user): bool
    {
        return in_array(
            $user->role,
            [
                'Admin',
                'Manager',
            ],
            true
        );
    }



    /**
     * Determine whether the user can update a project.
     */
    public function update(
        User $user,
        Project $project
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }


        if ($user->role === 'Manager') {

            return $this->isOwnerManager(
                $user,
                $project
            );
        }


        return false;
    }



    /**
     * Determine whether the user can delete a project.
     */
    public function delete(
        User $user,
        Project $project
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }


        if ($user->role === 'Manager') {

            return $this->isOwnerManager(
                $user,
                $project
            );
        }


        return false;
    }



    /**
     * Determine whether the user can archive a project.
     */
    public function archive(
        User $user,
        Project $project
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }


        if ($user->role === 'Manager') {

            return $this->isOwnerManager(
                $user,
                $project
            );
        }


        return false;
    }



    /**
     * Determine whether the user can restore a project.
     */
    public function restore(
        User $user,
        Project $project
    ): bool {

        if ($user->role === 'Admin') {
            return true;
        }


        if ($user->role === 'Manager') {

            return $this->isOwnerManager(
                $user,
                $project
            );
        }


        return false;
    }



    /**
     * Check Manager ownership.
     *
     * Manager can only manage projects
     * belonging to clients created by them.
     */
    private function isOwnerManager(
        User $user,
        Project $project
    ): bool {

        return $project->client
            &&
            (int) $project->client->created_by
            ===
            (int) $user->id;
    }



    /**
     * Check project membership.
     *
     * Members can only access projects
     * assigned through project_user table.
     */
    private function isProjectMember(
        User $user,
        Project $project
    ): bool {

        return $project
            ->members()
            ->where(
                'users.id',
                $user->id
            )
            ->exists();
    }
}
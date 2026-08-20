<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    /**
     * Determine whether the user can view any clients.
     */
    public function viewAny(User $user): bool
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
     * Determine whether the user can view the client.
     *
     * Admin:
     * - Can view all clients.
     *
     * Manager:
     * - Can view only clients created by themselves.
     */
    public function view(
        User $user,
        Client $client
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

        return $user->role === 'Manager'
            && (int) $client->created_by === (int) $user->id;
    }


    /**
     * Determine whether the user can create clients.
     *
     * Admin:
     * - Can create clients.
     *
     * Manager:
     * - Can create clients.
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
     * Determine whether the user can update the client.
     *
     * Admin:
     * - Can update any client.
     *
     * Manager:
     * - Can update only clients created by themselves.
     */
    public function update(
        User $user,
        Client $client
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

        return $user->role === 'Manager'
            && (int) $client->created_by === (int) $user->id;
    }


    /**
     * Determine whether the user can delete the client.
     *
     * Admin:
     * - Can delete any client.
     *
     * Manager:
     * - Can delete only clients created by themselves.
     */
    public function delete(
        User $user,
        Client $client
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

        return $user->role === 'Manager'
            && (int) $client->created_by === (int) $user->id;
    }
}
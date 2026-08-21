<?php

namespace App\Http\Controllers;


use App\Actions\Team\ActivateUser;
use App\Actions\Team\CreateTeamMember;
use App\Actions\Team\DeactivateUser;
use App\Actions\Team\GetTeamMemberDetails;
use App\Actions\Team\GetTeamMembers;
use App\Actions\Team\UpdateTeamMember;


use App\Http\Requests\StoreTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;


use App\Models\User;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;



class TeamController extends Controller
{


    public function index(
        GetTeamMembers $getTeamMembers
    )
    {

        $users = $getTeamMembers->handle();


        return view(
            'team.index',
            compact('users')
        );

    }





    public function create()
    {

        return view(
            'team.create'
        );

    }





    public function store(
        StoreTeamMemberRequest $request,
        CreateTeamMember $createTeamMember
    )
    {

        $createTeamMember->handle(
            $request->validated()
        );


        return Redirect::route(
            'team.index'
        )
        ->with(
            'success',
            'New team member created successfully.'
        );

    }





    public function show(
        User $user,
        GetTeamMemberDetails $getTeamMemberDetails
    )
    {

        return view(
            'team.show',
            $getTeamMemberDetails->handle(
                $user
            )
        );

    }





    public function edit(
        User $user
    )
    {

        return view(
            'team.edit',
            compact('user')
        );

    }





    public function update(
        UpdateTeamMemberRequest $request,
        User $user,
        UpdateTeamMember $updateTeamMember
    )
    {

        $updateTeamMember->handle(
            $user,
            $request->validated()
        );


        return Redirect::route(
            'team.index'
        )
        ->with(
            'success',
            'Team member updated successfully.'
        );

    }





    public function deactivate(
        User $user,
        DeactivateUser $deactivateUser
    )
    {

        try {

            $deactivateUser->handle(
                $user
            );


        } catch (ValidationException $exception) {


            return back()
                ->withErrors(
                    $exception->errors()
                );

        }


        return Redirect::route(
            'team.index'
        )
        ->with(
            'success',
            'User account deactivated successfully.'
        );

    }





    public function activate(
        User $user,
        ActivateUser $activateUser
    )
    {

        $activateUser->handle(
            $user
        );


        return Redirect::route(
            'team.index'
        )
        ->with(
            'success',
            'User account activated successfully.'
        );

    }


}
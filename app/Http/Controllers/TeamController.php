<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeamController extends Controller
{


    /**
     * Display all team members
     */
    public function index()
    {

        $users = User::latest()
            ->paginate(10);


        return view(
            'team.index',
            compact('users')
        );

    }





    /**
     * Show create user form
     */
    public function create()
    {

        return view('team.create');

    }





    /**
     * Store new user
     */
    public function store(Request $request)
    {


        $validated = $request->validate([


            'name' => [
                'required',
                'string',
                'max:255'
            ],


            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],


            'phone' => [
                'nullable',
                'string',
                'max:20'
            ],


            'role' => [
                'required',
                'in:Admin,Manager,Member'
            ],


          'password' => [

    'required',

    'confirmed',

    Password::min(8)
        ->mixedCase()
        ->letters()
        ->numbers()
        ->symbols(),

],


        ]);





        User::create([


            'name' => $validated['name'],


            'email' => $validated['email'],


            'phone' => $validated['phone'] ?? null,


            'role' => $validated['role'],


            'password' => Hash::make(
                $validated['password']
            ),


            'is_active' => true,


            'is_logged_in' => false,


        ]);





        return redirect()

            ->route('team.index')

            ->with(
                'success',
                'New team member created successfully.'
            );

    }





    /**
     * Display user details
     */
    public function show(User $user)
    {


        /*
        |--------------------------------------------------------------------------
        | User Assigned Tasks
        |--------------------------------------------------------------------------
        */


        $tasks = Task::where(
                'assigned_to',
                $user->id
            )
            ->with([
                'project',
                'timeLogs'
            ])
            ->latest()
            ->get();





        /*
        |--------------------------------------------------------------------------
        | Task Statistics
        |--------------------------------------------------------------------------
        */


        $totalTasks = $tasks->count();



        $todoTasks = $tasks
            ->where('status','Todo')
            ->count();



        $progressTasks = $tasks
            ->where('status','In Progress')
            ->count();



        $completedTasks = $tasks
            ->where('status','Done')
            ->count();





        $overdueTasks = $tasks
            ->filter(function($task){

                return $task->due_date
                    &&
                    $task->due_date->isPast()
                    &&
                    $task->status !== 'Done';

            })
            ->count();





        /*
        |--------------------------------------------------------------------------
        | Time Logs
        |--------------------------------------------------------------------------
        */


        $totalLogMinutes = $tasks->sum(function($task){

            return $task->timeLogs
                ->sum('minutes');

        });




        $totalLogHours = intdiv(
            $totalLogMinutes,
            60
        );



        $remainingMinutes = $totalLogMinutes % 60;





        return view(
            'team.show',
            compact(

                'user',

                'tasks',

                'totalTasks',

                'todoTasks',

                'progressTasks',

                'completedTasks',

                'overdueTasks',

                'totalLogMinutes',

                'totalLogHours',

                'remainingMinutes'

            )
        );


    }





    /**
     * Show edit form
     */
    public function edit(User $user)
    {

        return view(
            'team.edit',
            compact('user')
        );

    }





    /**
     * Update user details
     */
    public function update(Request $request, User $user)
    {


        $validated = $request->validate([


            'name' => [
                'required',
                'string',
                'max:255'
            ],



            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ],



            'phone' => [
                'nullable',
                'string',
                'max:20'
            ],



            'role' => [
                'required',
                'in:Admin,Manager,Member'
            ],


        ]);





        $user->update($validated);





        return redirect()

            ->route('team.index')

            ->with(
                'success',
                'Team member updated successfully.'
            );

    }





    /**
     * Deactivate user
     */
    public function deactivate(User $user)
    {


        if(auth()->id() === $user->id)
        {

            return back()

                ->with(
                    'error',
                    'You cannot deactivate your own account.'
                );

        }





        $user->update([


            'is_active' => false,


            'is_logged_in' => false,


        ]);





        return redirect()

            ->route('team.index')

            ->with(
                'success',
                'User account deactivated successfully.'
            );

    }





    /**
     * Activate user
     */
    public function activate(User $user)
    {


        $user->update([


            'is_active' => true,


        ]);





        return redirect()

            ->route('team.index')

            ->with(
                'success',
                'User account activated successfully.'
            );

    }


}
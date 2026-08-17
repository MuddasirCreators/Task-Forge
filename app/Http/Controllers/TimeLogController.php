<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTimeLogRequest;
use App\Http\Requests\UpdateTimeLogRequest;


class TimeLogController extends Controller
{

    /**
     * Display Time Logs
     */
    public function index(Task $task)
    {
        $timeLogs = $task->timeLogs()
            ->with('user')
            ->latest()
            ->paginate(10);


        return view('time_logs.index', compact(
            'task',
            'timeLogs'
        ));
    }



    /**
     * Show Create Form
     */
    public function create(Task $task)
    {
        return view('time_logs.create', compact(
            'task'
        ));
    }




    /**
     * Store Time Log
     */
    public function store(
        StoreTimeLogRequest $request,
        Task $task
    ) {

        try {


            TimeLog::create([

                'task_id' => $task->id,

                'user_id' => Auth::id(),

                'minutes' => $request->minutes,

                'logged_at' => $request->logged_at,

                'note' => $request->note,

            ]);


            return redirect()
                ->route('tasks.time-logs.index', $task)
                ->with(
                    'success',
                    'Time log added successfully.'
                );


        } catch (Exception $exception) {


            return back()
                ->withInput()
                ->withErrors([

                    'error' => $exception->getMessage(),

                ]);

        }

    }





    /**
     * Show Edit Form
     */
    public function edit(TimeLog $timeLog)
    {

        return view(
            'time_logs.edit',
            compact('timeLog')
        );

    }





    /**
     * Update Time Log
     */
    public function update(
        UpdateTimeLogRequest $request,
        TimeLog $timeLog
    ) {


        try {


            $timeLog->update([


                'minutes' => $request->minutes,


                'logged_at' => $request->logged_at,


                'note' => $request->note,


            ]);



            return redirect()
                ->route(
                    'tasks.time-logs.index',
                    $timeLog->task
                )
                ->with(
                    'success',
                    'Time log updated successfully.'
                );


        } catch (Exception $exception) {


            return back()
                ->withInput()
                ->withErrors([

                    'error' => $exception->getMessage(),

                ]);

        }

    }





    /**
     * Delete Time Log
     */
    public function destroy(TimeLog $timeLog)
    {


        try {


            $task = $timeLog->task;


            $timeLog->delete();



            return redirect()
                ->route(
                    'tasks.time-logs.index',
                    $task
                )
                ->with(
                    'success',
                    'Time log deleted successfully.'
                );


        } catch (Exception $exception) {


            return back()
                ->withErrors([

                    'error' => $exception->getMessage(),

                ]);

        }

    }

}
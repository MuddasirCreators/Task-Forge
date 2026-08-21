<?php

namespace App\Http\Controllers;


use App\Actions\TimeLogs\CreateTimeLog;
use App\Actions\TimeLogs\DeleteTimeLog;
use App\Actions\TimeLogs\GetTimeLogs;
use App\Actions\TimeLogs\UpdateTimeLog;


use App\Http\Requests\StoreTimeLogRequest;
use App\Http\Requests\UpdateTimeLogRequest;


use App\Models\Task;
use App\Models\TimeLog;


use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;



class TimeLogController extends Controller
{


    public function index(
        Task $task,
        GetTimeLogs $getTimeLogs
    ) {


        Gate::authorize(
            'create',
            [
                TimeLog::class,
                $task
            ]
        );


        $timeLogs = $getTimeLogs->handle(
            $task
        );


        return view(
            'time_logs.index',
            compact(
                'task',
                'timeLogs'
            )
        );
    }





    public function create(
        Task $task
    ) {


        Gate::authorize(
            'create',
            [
                TimeLog::class,
                $task
            ]
        );


        return view(
            'time_logs.create',
            compact('task')
        );
    }





    public function store(
        StoreTimeLogRequest $request,
        Task $task,
        CreateTimeLog $createTimeLog
    ) {


        Gate::authorize(
            'create',
            [
                TimeLog::class,
                $task
            ]
        );


        try {


            $createTimeLog->handle(
                $task,
                auth()->id(),
                $request->validated()
            );


        } catch (ValidationException $exception) {


            return back()
                ->withInput()
                ->withErrors(
                    $exception->errors()
                );

        }



        return redirect()
            ->route(
                'tasks.time-logs.index',
                $task
            )
            ->with(
                'success',
                'Time log added successfully.'
            );
    }





    public function edit(
        TimeLog $timeLog
    ) {


        Gate::authorize(
            'update',
            $timeLog
        );


        return view(
            'time_logs.edit',
            compact('timeLog')
        );
    }





    public function update(
        UpdateTimeLogRequest $request,
        TimeLog $timeLog,
        UpdateTimeLog $updateTimeLog
    ) {


        Gate::authorize(
            'update',
            $timeLog
        );


        try {


            $updateTimeLog->handle(
                $timeLog,
                $request->validated()
            );


        } catch (ValidationException $exception) {


            return back()
                ->withInput()
                ->withErrors(
                    $exception->errors()
                );

        }



        return redirect()
            ->route(
                'tasks.time-logs.index',
                $timeLog->task
            )
            ->with(
                'success',
                'Time log updated successfully.'
            );
    }





    public function destroy(
        TimeLog $timeLog,
        DeleteTimeLog $deleteTimeLog
    ) {


        Gate::authorize(
            'delete',
            $timeLog
        );


        try {


            $deleteTimeLog->handle(
                $timeLog
            );


        } catch (ValidationException $exception) {


            return back()
                ->withErrors(
                    $exception->errors()
                );

        }



        return redirect()
            ->route(
                'tasks.time-logs.index',
                $timeLog->task
            )
            ->with(
                'success',
                'Time log deleted successfully.'
            );
    }


}
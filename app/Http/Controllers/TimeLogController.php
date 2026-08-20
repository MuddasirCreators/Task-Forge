<?php

namespace App\Http\Controllers;

use App\Actions\TimeLogs\CreateTimeLog;
use App\Actions\TimeLogs\DeleteTimeLog;
use App\Actions\TimeLogs\UpdateTimeLog;

use App\Models\Task;
use App\Models\TimeLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\StoreTimeLogRequest;
use App\Http\Requests\UpdateTimeLogRequest;

use Exception;

class TimeLogController extends Controller
{
    /**
     * Display Time Logs.
     *
     * User must have access to the task's time logs.
     */
    public function index(Task $task)
    {
        Gate::authorize(
            'create',
            [TimeLog::class, $task]
        );

        $timeLogs = $task->timeLogs()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view(
            'time_logs.index',
            compact(
                'task',
                'timeLogs'
            )
        );
    }


    /**
     * Show Create Form.
     */
    public function create(Task $task)
    {
        Gate::authorize(
            'create',
            [TimeLog::class, $task]
        );

        return view(
            'time_logs.create',
            compact('task')
        );
    }


    /**
     * Store Time Log.
     */
    public function store(
        StoreTimeLogRequest $request,
        Task $task,
        CreateTimeLog $createTimeLog
    ) {
        Gate::authorize(
            'create',
            [TimeLog::class, $task]
        );

        try {
            $createTimeLog->handle(
                $task,
                auth()->id(),
                $request->validated()
            );

            return redirect()
                ->route(
                    'tasks.time-logs.index',
                    $task
                )
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
     * Show Edit Form.
     */
    public function edit(TimeLog $timeLog)
    {
        Gate::authorize(
            'update',
            $timeLog
        );

        return view(
            'time_logs.edit',
            compact('timeLog')
        );
    }


    /**
     * Update Time Log.
     */
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
     * Delete Time Log.
     */
    public function destroy(
        TimeLog $timeLog,
        DeleteTimeLog $deleteTimeLog
    ) {
        Gate::authorize(
            'delete',
            $timeLog
        );

        try {
            $task = $timeLog->task;

            $deleteTimeLog->handle(
                $timeLog
            );

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
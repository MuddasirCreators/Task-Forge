<?php

namespace App\Actions\TimeLogs;

use App\Events\TimeLogCreated;
use App\Models\Task;
use App\Models\TimeLog;
use Illuminate\Support\Facades\DB;

class CreateTimeLog
{
    /**
     * Create a new time log.
     */
    public function handle(
        Task $task,
        int $userId,
        array $data
    ): TimeLog {
        return DB::transaction(function () use (
            $task,
            $userId,
            $data
        ) {
            $timeLog = TimeLog::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'minutes' => $data['minutes'],
                'logged_at' => $data['logged_at'],
                'note' => $data['note'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | TimeLog Created Audit Event
            |--------------------------------------------------------------------------
            */

            TimeLogCreated::dispatch(
                $timeLog
            );

            return $timeLog;
        });
    }
}
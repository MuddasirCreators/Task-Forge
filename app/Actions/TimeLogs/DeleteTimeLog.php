<?php

namespace App\Actions\TimeLogs;

use App\Events\TimeLogDeleted;
use App\Models\TimeLog;
use Illuminate\Support\Facades\DB;

class DeleteTimeLog
{
    /**
     * Delete a time log.
     */
    public function handle(
        TimeLog $timeLog
    ): void {
        DB::transaction(function () use (
            $timeLog
        ) {
            /*
            |--------------------------------------------------------------------------
            | Store Information Before Deletion
            |--------------------------------------------------------------------------
            */

            $timeLogId = $timeLog->id;

            $taskId = $timeLog->task_id;

            $userId = $timeLog->user_id;

            $minutes = $timeLog->minutes;

            /*
            |--------------------------------------------------------------------------
            | Delete TimeLog
            |--------------------------------------------------------------------------
            */

            $timeLog->delete();

            /*
            |--------------------------------------------------------------------------
            | TimeLog Deleted Audit Event
            |--------------------------------------------------------------------------
            */

            TimeLogDeleted::dispatch(
                $timeLogId,
                $taskId,
                $userId,
                $minutes
            );
        });
    }
}
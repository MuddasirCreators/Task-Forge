<?php

namespace App\Actions\TimeLogs;

use App\Events\TimeLogUpdated;
use App\Models\TimeLog;
use Illuminate\Support\Facades\DB;

class UpdateTimeLog
{
    /**
     * Update an existing time log.
     */
    public function handle(
        TimeLog $timeLog,
        array $data
    ): TimeLog {
        return DB::transaction(function () use (
            $timeLog,
            $data
        ) {
            $timeLog->update([
                'minutes' => $data['minutes'],
                'logged_at' => $data['logged_at'],
                'note' => $data['note'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Refresh TimeLog
            |--------------------------------------------------------------------------
            */

            $timeLog->refresh();

            /*
            |--------------------------------------------------------------------------
            | TimeLog Updated Audit Event
            |--------------------------------------------------------------------------
            */

            TimeLogUpdated::dispatch(
                $timeLog
            );

            return $timeLog;
        });
    }
}
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /*
        |--------------------------------------------------------------------------
        | Overdue Task Notifications
        |--------------------------------------------------------------------------
        |
        | Check for overdue tasks every hour.
        | The command dispatches the actual queued job.
        |
        */

       
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(
            __DIR__ . '/Commands'
        );

        require base_path(
            'routes/console.php'
        );
    }
}
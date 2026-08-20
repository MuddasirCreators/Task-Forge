<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimeLog;

use App\Policies\ClientPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use App\Policies\TimeLogPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Policies Registration
        |--------------------------------------------------------------------------
        */

        Gate::policy(
            Client::class,
            ClientPolicy::class
        );


        Gate::policy(
            Project::class,
            ProjectPolicy::class
        );


        Gate::policy(
            Task::class,
            TaskPolicy::class
        );


        Gate::policy(
            TimeLog::class,
            TimeLogPolicy::class
        );
    }
}
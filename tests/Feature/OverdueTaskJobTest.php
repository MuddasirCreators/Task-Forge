<?php

namespace Tests\Feature;

use App\Jobs\ProcessOverdueTask;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class OverdueTaskJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * An overdue task must dispatch the overdue task job.
     */
    public function test_overdue_task_dispatches_process_overdue_task_job(): void
    {
        Bus::fake();

        /*
        |--------------------------------------------------------------------------
        | Create Project
        |--------------------------------------------------------------------------
        |
        | TaskFactory expects an existing project in the database.
        |
        */
        $project = Project::factory()->create();

        /*
        |--------------------------------------------------------------------------
        | Create Overdue Task
        |--------------------------------------------------------------------------
        */
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'due_date' => now()->subDay(),
            'status' => 'In Progress',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Run Command
        |--------------------------------------------------------------------------
        */
        $this->artisan('tasks:notify-overdue')
            ->assertSuccessful();

        /*
        |--------------------------------------------------------------------------
        | Verify Job Was Dispatched
        |--------------------------------------------------------------------------
        */
        Bus::assertDispatched(
            ProcessOverdueTask::class,
            function (ProcessOverdueTask $job) use ($task): bool {
                return $job->task->is($task);
            }
        );
    }


    /**
     * A completed task must not dispatch the overdue job.
     */
    public function test_completed_task_does_not_dispatch_overdue_job(): void
    {
        Bus::fake();

        /*
        |--------------------------------------------------------------------------
        | Create Project
        |--------------------------------------------------------------------------
        */
        $project = Project::factory()->create();

        /*
        |--------------------------------------------------------------------------
        | Create Completed Task
        |--------------------------------------------------------------------------
        */
        Task::factory()->create([
            'project_id' => $project->id,
            'due_date' => now()->subDay(),
            'status' => 'Done',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Run Command
        |--------------------------------------------------------------------------
        */
        $this->artisan('tasks:notify-overdue')
            ->assertSuccessful();

        /*
        |--------------------------------------------------------------------------
        | Verify No Job Was Dispatched
        |--------------------------------------------------------------------------
        */
        Bus::assertNotDispatched(
            ProcessOverdueTask::class
        );
    }


    /**
     * A future task must not dispatch the overdue job.
     */
    public function test_future_task_does_not_dispatch_overdue_job(): void
    {
        Bus::fake();

        /*
        |--------------------------------------------------------------------------
        | Create Project
        |--------------------------------------------------------------------------
        */
        $project = Project::factory()->create();

        /*
        |--------------------------------------------------------------------------
        | Create Future Task
        |--------------------------------------------------------------------------
        */
        Task::factory()->create([
            'project_id' => $project->id,
            'due_date' => now()->addDay(),
            'status' => 'In Progress',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Run Command
        |--------------------------------------------------------------------------
        */
        $this->artisan('tasks:notify-overdue')
            ->assertSuccessful();

        /*
        |--------------------------------------------------------------------------
        | Verify No Job Was Dispatched
        |--------------------------------------------------------------------------
        */
        Bus::assertNotDispatched(
            ProcessOverdueTask::class
        );
    }
}
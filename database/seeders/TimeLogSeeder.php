<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class TimeLogSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role', 'Member')->get();
        $tasks = Task::all();

        if ($members->isEmpty() || $tasks->isEmpty()) {
            return;
        }

        TimeLog::factory()
            ->count(100)
            ->create()
            ->each(function ($timeLog) use ($members, $tasks) {

                $timeLog->update([
                    'task_id' => $tasks->random()->id,
                    'user_id' => $members->random()->id,
                ]);

            });
    }
}
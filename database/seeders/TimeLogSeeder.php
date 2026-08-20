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

        if ($members->isEmpty()) {
            return;
        }

        Task::all()
            ->values()
            ->each(function ($task, $index) use ($members) {

                $count = $index < 10 ? 4 : 3;

                TimeLog::factory()
                    ->count($count)
                    ->create([
                        'task_id' => $task->id,
                        'user_id' => $members->random()->id,
                    ]);
            });
    }
}
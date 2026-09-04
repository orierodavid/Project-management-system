<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckTasksDueSoon extends Command
{
    protected $signature = 'tasks:check-due-soon';
    protected $description = 'Notify assignees about tasks approaching their deadlines';

    public function handle(): int
    {
        $settings = Setting::current();
        $now = Carbon::now($settings->timezone);
        $until = $now->copy()->addHours($settings->task_due_soon_hours);

        Task::query()
            ->whereNotNull('deadline')
            ->whereBetween('deadline', [$now, $until])
            ->where('status', '!=', 'done')
            ->where('is_overdue', false)
            ->whereNotNull('assigned_to')
            ->with('assignee')
            ->each(function (Task $task): void {
                $task->assignee?->notify(new \App\Notifications\TaskDueSoonNotification($task));
            });

        return self::SUCCESS;
    }
}

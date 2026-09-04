<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\Task;
use App\Notifications\TaskEventNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;

class CheckTaskDueSoon extends Command
{
    protected $signature = 'tasks:check-due-soon';
    protected $description = 'Notify assignees about tasks approaching their deadlines';

    public function handle(): int
    {
        $hours = max(1, (int) Setting::current()->task_due_soon_hours);
        $now = now();
        $until = $now->copy()->addHours($hours);

        Task::query()
            ->whereNotNull('assigned_to')
            ->whereNotNull('deadline')
            ->where('status', '!=', 'done')
            ->where('is_overdue', false)
            ->whereBetween('deadline', [$now, $until])
            ->with('assignee')
            ->each(function (Task $task): void {
                $assignee = $task->assignee;
                if (! $assignee) {
                    return;
                }

                $alreadySent = DatabaseNotification::query()
                    ->where('notifiable_type', $assignee->getMorphClass())
                    ->where('notifiable_id', $assignee->id)
                    ->where('type', TaskEventNotification::class)
                    ->where('created_at', '>=', now()->subDay())
                    ->where('data->task_id', $task->id)
                    ->where('data->event', 'Task due soon')
                    ->exists();

                if (! $alreadySent) {
                    $assignee->notify(new TaskEventNotification(
                        $task,
                        'Task due soon',
                        'This task is due within '.$task->deadline?->diffForHumans().'.',
                    ));
                }
            });

        return self::SUCCESS;
    }
}

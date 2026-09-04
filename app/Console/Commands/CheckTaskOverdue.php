<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskEventNotification;
use Illuminate\Console\Command;

class CheckTaskOverdue extends Command
{
    protected $signature = 'tasks:check-overdue';

    protected $description = 'Mark overdue tasks and notify their assignees';

    public function handle(): int
    {
        Task::query()
            ->whereNotNull('deadline')
            ->where('status', '!=', 'done')
            ->where('is_overdue', false)
            ->where('deadline', '<', now())
            ->with('assignee')
            ->each(function (Task $task): void {
                $task->forceFill(['is_overdue' => true])->save();

                if ($task->assignee) {
                    $task->assignee->notify(new TaskEventNotification(
                        $task,
                        'Task overdue',
                        'This task has passed its deadline and needs attention.',
                    ));
                }
            });

        return self::SUCCESS;
    }
}

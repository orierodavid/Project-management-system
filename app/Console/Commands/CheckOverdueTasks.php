<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckOverdueTasks extends Command
{
    protected $signature = 'tasks:check-overdue';
    protected $description = 'Mark unfinished tasks past their deadlines as overdue';

    public function handle(): int
    {
        $count = Task::query()
            ->whereNotNull('deadline')
            ->where('deadline', '<', Carbon::now())
            ->where('status', '!=', 'done')
            ->where('is_overdue', false)
            ->update(['is_overdue' => true]);

        $this->info("Marked {$count} task(s) as overdue.");

        return self::SUCCESS;
    }
}

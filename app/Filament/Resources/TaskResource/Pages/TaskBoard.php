<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\Page;

class TaskBoard extends Page
{
    protected static string $resource = TaskResource::class;

    protected static string $view = 'filament.resources.task-resource.pages.task-board';

    protected static ?string $title = 'Task Board';

    public function getViewData(): array
    {
        $tasks = TaskResource::getEloquentQuery()
            ->orderByRaw("CASE status WHEN 'in_progress' THEN 1 WHEN 'review' THEN 2 WHEN 'todo' THEN 3 WHEN 'done' THEN 4 ELSE 5 END")
            ->orderBy('deadline')
            ->get();

        return [
            'columns' => [
                'todo' => ['label' => 'To do', 'description' => 'Ready to be started'],
                'in_progress' => ['label' => 'In progress', 'description' => 'Currently being worked on'],
                'review' => ['label' => 'Review', 'description' => 'Waiting for final review'],
                'done' => ['label' => 'Done', 'description' => 'Completed work'],
            ],
            'tasks' => $tasks->groupBy('status'),
        ];
    }
}

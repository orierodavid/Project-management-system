<?php

namespace App\Filament\Pages;

use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Pages\Page;

class StaffTasks extends Page
{
    protected static string $view = 'filament.pages.staff-tasks';

    protected static string $routePath = 'tasks';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'My Tasks';

    protected static ?string $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'My Tasks';

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return (bool) $user?->hasRole('Staff');
    }

    public function getViewData(): array
    {
        $user = Filament::auth()->user();
        abort_unless(static::canAccess(), 403);

        $tasks = Task::query()
            ->with(['department', 'branch'])
            ->where('assigned_to', $user->id)
            ->orderByRaw('CASE WHEN status = \'done\' THEN 1 ELSE 0 END')
            ->orderByRaw('CASE WHEN deadline IS NULL THEN 1 ELSE 0 END')
            ->orderBy('deadline')
            ->get();

        return [
            'tasks' => $tasks,
            'openCount' => $tasks->where('status', '!=', 'done')->count(),
            'completedCount' => $tasks->where('status', 'done')->count(),
            'dueSoonCount' => $tasks->whereNotNull('deadline')->whereBetween('deadline', [now(), now()->copy()->addDays(2)])->where('status', '!=', 'done')->count(),
        ];
    }
}

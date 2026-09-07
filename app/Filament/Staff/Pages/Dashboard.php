<?php

namespace App\Filament\Staff\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = 'dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Overview';

    protected static ?string $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'My Overview';

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return (bool) ($user?->isActive() && $user->hasRole('Staff') && !$user->hasAnyRole(['Super Admin', 'Admin']));
    }

    public function getViewData(): array
    {
        $user = Filament::auth()->user();
        abort_unless(static::canAccess(), 403);

        $tasks = $user->assignedTasks();

        return [
            'currentUser' => $user,
            'openTaskCount' => (clone $tasks)->whereNot('status', 'done')->count(),
            'completedCount' => (clone $tasks)->where('status', 'done')->count(),
            'dueSoonCount' => (clone $tasks)
                ->whereNotNull('deadline')
                ->whereBetween('deadline', [now(), now()->copy()->addDays(2)])
                ->whereNot('status', 'done')
                ->count(),
        ];
    }
}

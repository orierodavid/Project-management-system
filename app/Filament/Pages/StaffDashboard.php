<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Carbon;

class StaffDashboard extends BaseDashboard
{
    protected static string $view = 'filament.pages.staff-dashboard';

    protected static string $routePath = 'dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Overview';

    protected static ?string $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'My Overview';

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return (bool) ($user && $user->isActive() && $user->hasRole('Staff') && ! $user->hasRole('Super Admin') && ! $user->hasRole('Admin'));
    }

    public function getViewData(): array
    {
        $user = Filament::auth()->user();
        abort_unless(static::canAccess(), 403);

        $today = Carbon::today();
        $tasks = $user->assignedTasks();

        return [
            'currentUser' => $user,
            'taskCount' => (clone $tasks)->whereNotIn('status', ['done'])->count(),
            'completedCount' => (clone $tasks)->where('status', 'done')->count(),
            'dueSoonCount' => (clone $tasks)->whereNotNull('deadline')->whereBetween('deadline', [now(), now()->copy()->addDays(2)])->whereNot('status', 'done')->count(),
            'todayAttendance' => $user->attendanceRecords()->whereDate('clock_in_at', $today)->latest('clock_in_at')->first(),
            'tasks' => (clone $tasks)->with(['department', 'branch'])->orderByRaw("CASE WHEN status = 'done' THEN 1 ELSE 0 END")->orderBy('deadline')->limit(6)->get(),
        ];
    }
}

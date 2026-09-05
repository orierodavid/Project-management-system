<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Carbon;

class StaffDashboard extends BaseDashboard
{
    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Dashboard';

    public static function getSlug(): string
    {
        return 'dashboard';
    }

    public function getViewData(): array
    {
        $user = Filament::auth()->user();
        abort_unless($user && $user->isActive() && $user->hasRole('Staff'), 403);
        auth()->setUser($user);

        $today = Carbon::today();
        $tasks = $user->assignedTasks();
        $todayAttendance = $user->attendanceRecords()
            ->whereDate('clock_in_at', $today)
            ->latest('clock_in_at')
            ->first();

        return [
            'mode' => 'staff',
            'currentUser' => $user,
            'taskCount' => (clone $tasks)->whereNotIn('status', ['done'])->count(),
            'completedCount' => (clone $tasks)->where('status', 'done')->count(),
            'dueSoonCount' => (clone $tasks)->whereNotNull('deadline')->whereBetween('deadline', [now(), now()->copy()->addDays(2)])->whereNot('status', 'done')->count(),
            'todayAttendance' => $todayAttendance,
            'tasks' => (clone $tasks)->with(['department', 'branch'])->orderByRaw("CASE WHEN status = 'done' THEN 1 ELSE 0 END")->orderBy('deadline')->limit(5)->get(),
        ];
    }
}

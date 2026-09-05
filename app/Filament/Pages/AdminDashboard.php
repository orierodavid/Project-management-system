<?php

namespace App\Filament\Pages;

use App\Models\AttendanceRecord;
use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Carbon;

class AdminDashboard extends BaseDashboard
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

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return (bool) ($user && $user->isActive() && $user->hasAnyRole(['Super Admin', 'Admin']));
    }

    public function getViewData(): array
    {
        $user = Filament::auth()->user();
        abort_unless(static::canAccess(), 403);
        auth()->setUser($user);

        $today = Carbon::today();
        $branchIds = $user->branches()->pluck('branches.id');
        $taskQuery = Task::query();
        $attendanceQuery = AttendanceRecord::query();

        if (! $user->hasRole('Super Admin')) {
            $taskQuery->where(function ($query) use ($branchIds) {
                $query->whereIn('branch_id', $branchIds)->orWhereNull('branch_id');
            });
            $attendanceQuery->whereIn('branch_id', $branchIds);
        }

        $attendanceTrend = [];
        for ($offset = 6; $offset >= 0; $offset--) {
            $date = $today->copy()->subDays($offset);
            $attendanceTrend[] = [
                'label' => $date->format('D'),
                'date' => $date->format('M j'),
                'count' => (clone $attendanceQuery)->whereDate('clock_in_at', $date)->count(),
            ];
        }

        $taskPipeline = collect([
            'todo' => ['label' => 'To do', 'count' => (clone $taskQuery)->where('status', 'todo')->count()],
            'in_progress' => ['label' => 'In progress', 'count' => (clone $taskQuery)->where('status', 'in_progress')->count()],
            'review' => ['label' => 'Review', 'count' => (clone $taskQuery)->where('status', 'review')->count()],
            'done' => ['label' => 'Completed', 'count' => (clone $taskQuery)->where('status', 'done')->count()],
        ])->values()->all();

        return [
            'mode' => 'admin',
            'currentUser' => $user,
            'userCount' => User::query()->where('status', 'active')->count(),
            'taskCount' => (clone $taskQuery)->whereNot('status', 'done')->count(),
            'overdueCount' => (clone $taskQuery)->where('is_overdue', true)->whereNot('status', 'done')->count(),
            'presentCount' => (clone $attendanceQuery)->whereDate('clock_in_at', $today)->count(),
            'recentTasks' => (clone $taskQuery)->with('assignee')->latest()->limit(6)->get(),
            'attendanceTrend' => $attendanceTrend,
            'taskPipeline' => $taskPipeline,
        ];
    }
}

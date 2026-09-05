<?php

namespace App\Filament\Pages;

use App\Models\AttendanceRecord;
use App\Models\Task;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Carbon;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Dashboard';

    public function getViewData(): array
    {
        $user = auth()->user();
        $isStaff = $user?->hasRole('Staff') && ! $user?->hasAnyRole(['Admin', 'Super Admin']);
        $today = Carbon::today();

        if ($isStaff) {
            $tasks = $user->assignedTasks();
            $todayAttendance = $user->attendanceRecords()
                ->whereDate('clock_in_at', $today)
                ->latest('clock_in_at')
                ->first();

            return [
                'mode' => 'staff',
                'taskCount' => (clone $tasks)->whereNotIn('status', ['done'])->count(),
                'completedCount' => (clone $tasks)->where('status', 'done')->count(),
                'dueSoonCount' => (clone $tasks)->whereNotNull('deadline')->whereBetween('deadline', [now(), now()->copy()->addDays(2)])->whereNot('status', 'done')->count(),
                'todayAttendance' => $todayAttendance,
                'tasks' => (clone $tasks)->with(['department', 'branch'])->orderByRaw("CASE WHEN status = 'done' THEN 1 ELSE 0 END")->orderBy('deadline')->limit(5)->get(),
            ];
        }

        $branchIds = $user?->branches()->pluck('branches.id') ?? collect();
        $taskQuery = Task::query();
        $attendanceQuery = AttendanceRecord::query();

        if ($user && ! $user->hasRole('Super Admin')) {
            $taskQuery->where(function ($query) use ($branchIds) {
                $query->whereIn('branch_id', $branchIds)->orWhereNull('branch_id');
            });
            $attendanceQuery->whereIn('branch_id', $branchIds);
        }

        return [
            'mode' => 'admin',
            'userCount' => User::query()->where('status', 'active')->count(),
            'taskCount' => (clone $taskQuery)->whereNot('status', 'done')->count(),
            'overdueCount' => (clone $taskQuery)->where('is_overdue', true)->whereNot('status', 'done')->count(),
            'presentCount' => (clone $attendanceQuery)->whereDate('clock_in_at', $today)->count(),
            'recentTasks' => (clone $taskQuery)->with('assignee')->latest()->limit(6)->get(),
        ];
    }
}

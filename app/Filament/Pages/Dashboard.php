<?php

namespace App\Filament\Pages;

use App\Models\AttendanceRecord;
use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;
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
        $panelId = Filament::getCurrentPanel()?->getId();
        $user = Filament::auth()->user();
        $isStaff = $panelId === 'staff';
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

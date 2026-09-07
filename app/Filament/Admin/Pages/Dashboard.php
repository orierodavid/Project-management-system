<?php

namespace App\Filament\Admin\Pages;

use App\Models\AttendanceRecord;
use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Carbon;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Admin Dashboard';

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return (bool) ($user?->isActive() && $user->hasAnyRole(['Super Admin', 'Admin']) && !$user->hasRole('Staff'));
    }

    public function getViewData(): array
    {
        $user = Filament::auth()->user();
        abort_unless(static::canAccess(), 403);

        $today = Carbon::today();
        $taskQuery = Task::query();
        $attendanceQuery = AttendanceRecord::query();

        if ($user->hasRole('Admin')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $taskQuery->where(function ($query) use ($branchIds) {
                $query->whereIn('branch_id', $branchIds)->orWhereNull('branch_id');
            });
            $attendanceQuery->whereIn('branch_id', $branchIds);
        }

        return [
            'currentUser' => $user,
            'userCount' => User::query()->where('status', 'active')->count(),
            'openTaskCount' => (clone $taskQuery)->whereNot('status', 'done')->count(),
            'overdueCount' => (clone $taskQuery)->where('is_overdue', true)->whereNot('status', 'done')->count(),
            'presentCount' => (clone $attendanceQuery)->whereDate('clock_in_at', $today)->count(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AttendanceRecord;
use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = Filament::auth()->user();
        $tasks = Task::query();
        $attendance = AttendanceRecord::query();

        if ($user?->hasRole('Admin')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $tasks->where(function ($query) use ($branchIds) {
                $query->whereIn('branch_id', $branchIds)->orWhereNull('branch_id');
            });
            $attendance->whereIn('branch_id', $branchIds);
        }

        return [
            Stat::make('Active staff', User::query()->where('status', 'active')->role('Staff', 'web')->count())
                ->description('Staff accounts currently active')
                ->icon('heroicon-o-users'),
            Stat::make('Open tasks', (clone $tasks)->whereNot('status', 'done')->count())
                ->description('Tasks still in progress')
                ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Overdue', (clone $tasks)->where('is_overdue', true)->whereNot('status', 'done')->count())
                ->description('Open tasks past deadline')
                ->icon('heroicon-o-exclamation-triangle'),
            Stat::make('Present today', (clone $attendance)->whereDate('clock_in_at', today())->count())
                ->description('Attendance records for today')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}

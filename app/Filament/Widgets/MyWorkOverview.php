<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class MyWorkOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $tasks = Task::query();

        if ($user?->hasRole('Staff')) {
            $tasks->where('assigned_to', $user->id);
        } elseif ($user?->hasRole('Admin')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $tasks->where(function ($query) use ($branchIds) {
                $query->whereIn('branch_id', $branchIds)->orWhereNull('branch_id');
            });
        }

        $today = Carbon::now();
        $dueSoonHours = Setting::current()->task_due_soon_hours;
        $openAttendance = $user?->attendanceRecords()->whereNull('clock_out_at')->exists();

        return [
            Stat::make('Open tasks', (clone $tasks)->whereNotIn('status', ['done'])->count())
                ->description('Tasks still requiring work')
                ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Due soon', (clone $tasks)->whereNotNull('deadline')->whereBetween('deadline', [$today, $today->copy()->addHours($dueSoonHours)])->whereNot('status', 'done')->count())
                ->description("Due within {$dueSoonHours} hours")
                ->icon('heroicon-o-clock'),
            Stat::make('Overdue', (clone $tasks)->where('is_overdue', true)->whereNot('status', 'done')->count())
                ->description('Past their deadline')
                ->icon('heroicon-o-exclamation-triangle'),
            Stat::make('Attendance', $openAttendance ? 'Clocked in' : 'Not clocked in')
                ->description('Current attendance state')
                ->icon('heroicon-o-map-pin'),
        ];
    }
}

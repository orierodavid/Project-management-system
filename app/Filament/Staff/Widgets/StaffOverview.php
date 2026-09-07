<?php

namespace App\Filament\Staff\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StaffOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = Filament::auth()->user();
        $tasks = $user->assignedTasks();

        return [
            Stat::make('My open tasks', (clone $tasks)->whereNot('status', 'done')->count())
                ->description('Tasks assigned to you')
                ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Due soon', (clone $tasks)
                ->whereNotNull('deadline')
                ->whereBetween('deadline', [now(), now()->copy()->addDays(2)])
                ->whereNot('status', 'done')
                ->count())
                ->description('Due within two days')
                ->icon('heroicon-o-clock'),
            Stat::make('Completed', (clone $tasks)->where('status', 'done')->count())
                ->description('Tasks you have completed')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Attendance', $user->attendanceRecords()->whereNull('clock_out_at')->exists() ? 'Clocked in' : 'Not clocked in')
                ->description('Your current attendance state')
                ->icon('heroicon-o-map-pin'),
        ];
    }
}

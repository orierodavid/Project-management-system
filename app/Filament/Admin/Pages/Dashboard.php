<?php

namespace App\Filament\Admin\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;

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

        return (bool) ($user?->isActive() && $user->hasAnyRole(['Super Admin', 'Admin']) && ! $user->hasRole('Staff'));
    }
}

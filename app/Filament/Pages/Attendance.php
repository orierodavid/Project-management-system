<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Attendance extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Attendance';

    protected static ?string $title = 'Attendance';

    protected static ?string $navigationGroup = 'My Work';

    protected static string $view = 'filament.pages.attendance';

    public static function canAccess(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        // Attendance is available to authenticated staff and administrators.
        // The individual clock actions remain protected by their own permissions.
        return $user->hasAnyRole(['Staff', 'Admin', 'Super Admin']);
    }
}

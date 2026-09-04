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
        return (bool) (auth()->user()?->can('clock-in') || auth()->user()?->can('clock-out'));
    }
}

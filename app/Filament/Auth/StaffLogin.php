<?php

namespace App\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Pages\Auth\Login as BaseLogin;

class StaffLogin extends BaseLogin
{
    protected static string $view = 'filament.auth.staff-login';

    protected function getRedirectUrl(): string
    {
        return Filament::getCurrentPanel()->getUrl();
    }
}

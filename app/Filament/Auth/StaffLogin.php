<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class StaffLogin extends BaseLogin
{
    protected static string $view = 'filament.auth.staff-login';
}

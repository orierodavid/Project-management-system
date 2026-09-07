<?php

namespace App\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static string $view = 'filament.auth.login';

    protected function getRedirectUrl(): string
    {
        return Filament::getCurrentPanel()->getUrl();
    }
}

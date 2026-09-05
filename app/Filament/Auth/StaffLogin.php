<?php

namespace App\Filament\Auth;

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;

class StaffLogin extends BaseLogin
{
    protected static string $view = 'filament.auth.staff-login';

    public function authenticate(): ?LoginResponse
    {
        session()->forget('url.intended');

        return parent::authenticate();
    }
}

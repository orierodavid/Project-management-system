<?php

namespace App\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Log;

class Login extends BaseLogin
{
    protected static string $view = 'filament.auth.login';

    public function authenticate(): ?LoginResponse
    {
        session()->forget('url.intended');

        $panel = Filament::getCurrentPanel();

        Log::info('Filament login redirect trace: before authentication', [
            'panel' => $panel?->getId(),
            'panel_path' => $panel?->getPath(),
            'guard' => $panel?->getAuthGuard(),
            'authenticated' => Filament::auth()->check(),
            'url' => request()->fullUrl(),
        ]);

        $response = parent::authenticate();

        $panel = Filament::getCurrentPanel();
        $user = Filament::auth()->user();

        Log::info('Filament login redirect trace: after authentication', [
            'panel' => $panel?->getId(),
            'panel_path' => $panel?->getPath(),
            'guard' => $panel?->getAuthGuard(),
            'authenticated' => Filament::auth()->check(),
            'user_id' => $user?->id,
            'roles' => $user?->getRoleNames()->values()->all(),
            'url' => request()->fullUrl(),
            'response_class' => $response ? get_class($response) : null,
        ]);

        return $response;
    }
}

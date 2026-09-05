<?php

namespace App\Http\Responses;

use App\Filament\Pages\AdminDashboard;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class AdminLoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        session()->forget('url.intended');

        return redirect()->to(AdminDashboard::getUrl(panel: 'admin'));
    }
}

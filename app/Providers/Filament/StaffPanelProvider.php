<?php

namespace App\Providers\Filament;

use App\Filament\Auth\StaffLogin;
use App\Filament\Pages\Attendance;
use App\Filament\Pages\StaffTasks;
use App\Filament\Staff\Pages\Dashboard;
use App\Filament\Staff\Widgets\StaffOverview;
use App\Models\Setting;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StaffPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('staff')
            ->path('staff')
            ->login(StaffLogin::class)
            ->authGuard('staff')
            ->brandName(fn (): string => Setting::current()->company_name ?: 'Project Management System')
            ->brandLogo(fn (): ?string => Setting::current()->company_logo
                ? Storage::disk('public')->url(Setting::current()->company_logo)
                : null)
            ->colors(['primary' => Color::hex(Setting::current()->primary_color ?: '#2563EB')])
            ->pages([
                Dashboard::class,
                StaffTasks::class,
                Attendance::class,
            ])
            ->widgets([
                StaffOverview::class,
            ])
            ->renderHook(PanelsRenderHook::HEAD_END, fn (): string => view('filament.theme')->render())
            ->renderHook(PanelsRenderHook::BODY_START, fn (): string => view('filament.product-shell')->render())
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

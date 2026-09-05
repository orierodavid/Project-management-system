<x-filament-panels::page.simple>
    <div class="pm-login-shell">
        <div class="pm-login-brand">
            <div class="pm-login-mark">P</div>
            <div><strong>{{ config('app.name', 'Project Management') }}</strong><span>WORKSPACE</span></div>
        </div>
        <div class="pm-login-copy">
            <p class="pm-eyebrow">Secure workspace</p>
            <h1>Welcome back.</h1>
            <p>Sign in to continue to your workspace.</p>
        </div>
        <form wire:submit="authenticate" class="pm-login-form">
            {{ $this->form }}
            @if (filament()->hasPasswordReset())
                <div class="pm-login-options"><a href="{{ filament()->getRequest()->getBaseUrl() . '/password-reset/request' }}">Forgot password?</a></div>
            @endif
            <x-filament::button type="submit" class="pm-login-submit" size="lg">Sign in <span aria-hidden="true">→</span></x-filament::button>
        </form>
        <p class="pm-login-footer">Protected workspace · Your access is managed by your organization.</p>
    </div>
</x-filament-panels::page.simple>

<x-filament-panels::page.simple>
    <div class="pm-staff-login">
        <div class="pm-staff-login-shell">
            <section class="pm-staff-login-brand">
                @php($setting = \App\Models\Setting::current())
                @if ($setting->company_logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($setting->company_logo) }}" alt="{{ $setting->company_name ?: 'Company' }}">
                @else
                    <div class="pm-staff-login-logo">{{ strtoupper(substr($setting->company_name ?: 'P', 0, 1)) }}</div>
                @endif
                <div>
                    <strong>{{ $setting->company_name ?: 'Project Management System' }}</strong>
                    <span>STAFF WORKSPACE</span>
                </div>
            </section>

            <section class="pm-staff-login-card">
                <div class="pm-staff-login-heading">
                    <span class="pm-staff-login-eyebrow">Team member access</span>
                    <h1>Welcome back</h1>
                    <p>Sign in to manage your tasks, attendance and daily work.</p>
                </div>

                <form wire:submit="authenticate" class="pm-staff-login-form">
                    {{ $this->form }}
                    @if (filament()->hasPasswordReset())
                        <a class="pm-staff-login-forgot" href="{{ filament()->getRequest()->getBaseUrl() . '/password-reset/request' }}">Forgot password?</a>
                    @endif
                    <x-filament::button type="submit" class="pm-staff-login-submit" size="lg">
                        Sign in to Staff Workspace <span aria-hidden="true">→</span>
                    </x-filament::button>
                </form>

                <p class="pm-staff-login-security"><span aria-hidden="true">●</span> Secure organization access</p>
            </section>
        </div>
    </div>

    <style>
        .pm-staff-login{min-height:calc(100vh - 2rem);display:grid;place-items:center;padding:32px 20px;background:#f6f8fb}
        .pm-staff-login-shell{width:min(480px,100%)}
        .pm-staff-login-brand{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:22px}
        .pm-staff-login-brand img{width:42px;height:42px;object-fit:contain;border-radius:10px;background:#fff;border:1px solid #e5e7eb;padding:5px}
        .pm-staff-login-logo{width:42px;height:42px;display:grid;place-items:center;border-radius:10px;background:#111827;color:#fff;font-size:17px;font-weight:800}
        .pm-staff-login-brand div:last-child{display:flex;flex-direction:column;line-height:1.2}
        .pm-staff-login-brand strong{color:#111827;font-size:14px;font-weight:750}
        .pm-staff-login-brand span{margin-top:4px;color:#667085;font-size:9px;font-weight:800;letter-spacing:.14em}
        .pm-staff-login-card{background:#fff;border:1px solid #e4e7ec;border-radius:18px;padding:38px;box-shadow:0 20px 55px rgba(16,24,40,.08)}
        .pm-staff-login-heading{margin-bottom:28px}
        .pm-staff-login-eyebrow{display:block;margin-bottom:8px;color:#2563eb;font-size:10px;font-weight:800;letter-spacing:.1em;text-transform:uppercase}
        .pm-staff-login-heading h1{margin:0;color:#101828;font-size:30px;line-height:1.15;font-weight:780;letter-spacing:-.04em}
        .pm-staff-login-heading p{margin:9px 0 0;color:#667085;font-size:13px;line-height:1.55}
        .pm-staff-login-form{display:flex;flex-direction:column;gap:15px}
        .pm-staff-login-form .fi-fo-field-wrp-label{color:#344054!important;font-size:11px;font-weight:700}
        .pm-staff-login-form .fi-input-wrp{background:#fff!important;border:1px solid #d0d5dd!important;border-radius:9px!important;min-height:46px}
        .pm-staff-login-form .fi-input{color:#101828!important;-webkit-text-fill-color:#101828!important;background:transparent!important}
        .pm-staff-login-form .fi-input::placeholder{color:#98a2b3!important}
        .pm-staff-login-form .fi-input-wrp:focus-within{border-color:#2563eb!important;box-shadow:0 0 0 3px rgba(37,99,235,.11)!important}
        .pm-staff-login-forgot{align-self:flex-end;color:#2563eb;font-size:11px;font-weight:650;text-decoration:none}
        .pm-staff-login-forgot:hover{text-decoration:underline}
        .pm-staff-login-submit{width:100%;justify-content:center;min-height:46px;margin-top:3px}
        .pm-staff-login-submit span{margin-left:auto;font-size:16px}
        .pm-staff-login-security{margin:25px 0 0;text-align:center;color:#98a2b3;font-size:10px}
        .pm-staff-login-security span{color:#12b76a;margin-right:5px}
        @media(max-width:520px){.pm-staff-login{padding:20px 14px}.pm-staff-login-card{padding:28px 20px;border-radius:15px}.pm-staff-login-heading h1{font-size:27px}}
    </style>
</x-filament-panels::page.simple>

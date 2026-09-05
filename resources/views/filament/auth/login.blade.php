@php
    $panelId = filament()->getCurrentPanel()?->getId();
    $isStaff = $panelId === 'staff';
    $setting = \App\Models\Setting::current();
    $logoUrl = $setting->company_logo ? \Illuminate\Support\Facades\Storage::disk('public')->url($setting->company_logo) : null;
@endphp

<x-filament-panels::page.simple>
    <div class="pm-login-v3 {{ $isStaff ? 'pm-login-v3-staff' : 'pm-login-v3-admin' }}">
        <section class="pm-login-visual" aria-hidden="true">
            <div class="pm-login-visual-top">
                <a class="pm-login-brand" href="{{ url('/') }}">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="" class="pm-login-logo">
                    @else
                        <span class="pm-login-logo-fallback">{{ strtoupper(substr($setting->company_name ?: config('app.name', 'PM'), 0, 1)) }}</span>
                    @endif
                    <span>
                        <strong>{{ $setting->company_name ?: config('app.name', 'Project Management') }}</strong>
                        <small>{{ $isStaff ? 'TEAM WORKSPACE' : 'MANAGEMENT WORKSPACE' }}</small>
                    </span>
                </a>
                <span class="pm-login-secure"><i></i> Secure sign in</span>
            </div>

            <div class="pm-login-visual-body">
                <span class="pm-login-overline">{{ $isStaff ? 'Your workspace' : 'Your command center' }}</span>
                <h2>{{ $isStaff ? 'Everything you need to get work done.' : 'Run your organization with clarity.' }}</h2>
                <p>{{ $isStaff ? 'Tasks, attendance and daily priorities in one focused workspace.' : 'Coordinate people, tasks and operations from one focused workspace.' }}</p>

                @if ($isStaff)
                    <div class="pm-login-activity">
                        <div class="pm-login-activity-icon">✓</div>
                        <div><strong>Ready for today</strong><span>Pick up where you left off.</span></div>
                    </div>
                @else
                    <div class="pm-login-activity">
                        <div class="pm-login-activity-icon">↗</div>
                        <div><strong>Workspace overview</strong><span>People, delivery and operations.</span></div>
                    </div>
                @endif
            </div>

            <div class="pm-login-visual-bottom">
                <span>© {{ now()->year }} {{ $setting->company_name ?: config('app.name', 'Project Management') }}</span>
                <span>Authorized access only</span>
            </div>
        </section>

        <main class="pm-login-content">
            <div class="pm-login-mobile-brand">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $setting->company_name ?: config('app.name', 'Project Management') }}">
                @else
                    <span>{{ strtoupper(substr($setting->company_name ?: config('app.name', 'PM'), 0, 1)) }}</span>
                @endif
            </div>

            <div class="pm-login-heading">
                <span class="pm-login-kicker">{{ $isStaff ? 'Team member sign in' : 'Administrator sign in' }}</span>
                <h1>{{ $isStaff ? 'Welcome back.' : 'Welcome back.' }}</h1>
                <p>{{ $isStaff ? 'Sign in to see your tasks, attendance and daily priorities.' : 'Sign in to manage your workspace.' }}</p>
            </div>

            <form wire:submit="authenticate" class="pm-login-form">
                {{ $this->form }}

                @if (filament()->hasPasswordReset())
                    <div class="pm-login-options">
                        <a href="{{ filament()->getRequest()->getBaseUrl() . '/password-reset/request' }}">Forgot password?</a>
                    </div>
                @endif

                <x-filament::button type="submit" class="pm-login-submit" size="lg">
                    <span>Sign in</span><b aria-hidden="true">→</b>
                </x-filament::button>
            </form>

            <div class="pm-login-note">
                <span class="pm-login-note-icon">i</span>
                <span>Your account access is managed by your organization.</span>
            </div>
        </main>
    </div>

    <style>
        .pm-login-v3{--login-ink:#101828;--login-muted:#667085;--login-line:#e4e7ec;--login-blue:#315efb;--login-blue-dark:#2447c8;--login-panel:#0f172a;display:grid;grid-template-columns:minmax(360px,.92fr) minmax(430px,1.08fr);width:min(1080px,100%);min-height:650px;margin:0 auto;background:#fff;border:1px solid #eaecf0;border-radius:20px;overflow:hidden;box-shadow:0 24px 70px rgba(16,24,40,.12);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}.pm-login-visual{display:flex;flex-direction:column;padding:30px 34px;background:linear-gradient(145deg,#111827 0%,#172554 100%);color:#fff;position:relative;overflow:hidden}.pm-login-visual:after{content:"";position:absolute;width:360px;height:360px;right:-180px;bottom:-160px;border:1px solid rgba(255,255,255,.1);border-radius:50%;box-shadow:0 0 0 70px rgba(255,255,255,.025),0 0 0 140px rgba(255,255,255,.018)}.pm-login-visual-top,.pm-login-visual-bottom,.pm-login-brand,.pm-login-secure{position:relative;z-index:1}.pm-login-visual-top{display:flex;align-items:center;justify-content:space-between;gap:16px}.pm-login-brand{display:flex;align-items:center;gap:11px;text-decoration:none;color:#fff}.pm-login-brand>span:last-child{display:flex;flex-direction:column;gap:3px}.pm-login-brand strong{font-size:13px;font-weight:750;letter-spacing:-.01em}.pm-login-brand small{color:#98a2b3;font-size:8px;font-weight:800;letter-spacing:.14em}.pm-login-logo,.pm-login-logo-fallback{width:38px;height:38px;border-radius:10px;object-fit:contain;background:#fff}.pm-login-logo-fallback{display:grid;place-items:center;color:#172554;font-size:15px;font-weight:850}.pm-login-secure{display:flex;align-items:center;gap:7px;color:#b8c0ce;font-size:10px;font-weight:650}.pm-login-secure i{width:6px;height:6px;border-radius:50%;background:#32d583;box-shadow:0 0 0 4px rgba(50,213,131,.1)}.pm-login-visual-body{position:relative;z-index:1;margin:auto 0;max-width:370px}.pm-login-overline,.pm-login-kicker{display:block;color:#91a9ff;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}.pm-login-visual-body h2{margin:11px 0 14px;color:#fff;font-size:38px;line-height:1.08;font-weight:760;letter-spacing:-.055em}.pm-login-visual-body>p{margin:0;color:#b7c0ce;font-size:14px;line-height:1.7;max-width:330px}.pm-login-activity{display:flex;align-items:center;gap:12px;margin-top:32px;padding:13px 14px;border:1px solid rgba(255,255,255,.1);border-radius:12px;background:rgba(255,255,255,.055);backdrop-filter:blur(8px)}.pm-login-activity-icon{display:grid;place-items:center;width:30px;height:30px;border-radius:8px;background:rgba(145,169,255,.16);color:#b9c7ff;font-size:14px;font-weight:800}.pm-login-activity div:last-child{display:flex;flex-direction:column;gap:2px}.pm-login-activity strong{font-size:11px;color:#fff}.pm-login-activity span{font-size:10px;color:#98a2b3}.pm-login-visual-bottom{display:flex;justify-content:space-between;gap:15px;color:#7f8a9c;font-size:9px}.pm-login-content{display:flex;flex-direction:column;justify-content:center;padding:64px 76px;background:#fff}.pm-login-mobile-brand{display:none}.pm-login-heading{margin-bottom:32px}.pm-login-heading h1{margin:8px 0 0;color:var(--login-ink)!important;font-size:34px;line-height:1.1;font-weight:780;letter-spacing:-.05em}.pm-login-heading p{margin:9px 0 0;color:var(--login-muted)!important;font-size:13px;line-height:1.6}.pm-login-form{display:flex;flex-direction:column;gap:17px}.pm-login-form .fi-fo-field-wrp-label{color:#344054!important;font-size:11px;font-weight:700}.pm-login-form .fi-input-wrp{min-height:46px;background:#fff!important;border:1px solid #d0d5dd!important;border-radius:9px!important;box-shadow:none!important}.pm-login-form .fi-input{color:#101828!important;-webkit-text-fill-color:#101828!important;background:transparent!important;font-size:13px}.pm-login-form .fi-input::placeholder{color:#98a2b3!important}.pm-login-form .fi-input-wrp:focus-within{border-color:var(--login-blue)!important;box-shadow:0 0 0 3px rgba(49,94,251,.1)!important}.pm-login-options{display:flex;justify-content:flex-end;margin-top:-4px}.pm-login-options a{color:var(--login-blue);font-size:11px;font-weight:700;text-decoration:none}.pm-login-options a:hover{text-decoration:underline}.pm-login-submit{width:100%;min-height:46px;justify-content:center;border-radius:9px!important;margin-top:1px;background:var(--login-blue)!important}.pm-login-submit:hover{background:var(--login-blue-dark)!important}.pm-login-submit b{margin-left:auto;font-size:16px;font-weight:500}.pm-login-note{display:flex;align-items:center;gap:8px;margin-top:28px;color:#98a2b3;font-size:10px;line-height:1.5}.pm-login-note-icon{display:grid;place-items:center;width:17px;height:17px;border:1px solid #d0d5dd;border-radius:50%;color:#667085;font-size:9px;font-weight:800;flex:0 0 auto}@media(max-width:820px){.pm-login-v3{grid-template-columns:1fr;min-height:auto;border-radius:16px}.pm-login-visual{min-height:300px;padding:24px}.pm-login-visual-body{margin:55px 0 20px}.pm-login-visual-body h2{font-size:29px}.pm-login-visual-bottom{display:none}.pm-login-content{padding:38px 30px 34px}.pm-login-heading{margin-bottom:26px}}@media(max-width:520px){.pm-login-v3{border:0;border-radius:0;box-shadow:none}.pm-login-visual{min-height:255px;padding:20px}.pm-login-secure{display:none}.pm-login-visual-body{margin:45px 0 5px}.pm-login-visual-body h2{font-size:25px}.pm-login-activity{margin-top:20px}.pm-login-content{padding:30px 20px}.pm-login-heading h1{font-size:29px}.pm-login-form{gap:15px}}
    </style>
</x-filament-panels::page.simple>

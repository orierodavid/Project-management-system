<x-filament-panels::page.simple>
    <div class="pm-login-v2">
        <aside class="pm-login-rail">
            <div class="pm-login-brand">
                <div class="pm-login-mark">P</div>
                <div><strong>{{ config('app.name', 'Project Management') }}</strong><span>WORKSPACE</span></div>
            </div>
            <div class="pm-login-rail-copy">
                <p class="pm-eyebrow">Your work, in one place.</p>
                <h2>Move projects forward with clarity.</h2>
                <p>Plan delivery, coordinate people and keep attendance accountable from one focused workspace.</p>
            </div>
            <div class="pm-login-rail-footer"><span></span>Secure organization workspace</div>
        </aside>

        <main class="pm-login-main">
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
        </main>
    </div>

    <style>
        .pm-login-v2{display:grid;grid-template-columns:minmax(280px,.9fr) minmax(420px,1.1fr);width:min(980px,100%);min-height:590px;margin:0 auto;overflow:hidden;background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 18px 50px rgba(16,24,40,.08);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}.pm-login-rail{display:flex;flex-direction:column;padding:30px;background:#172033;color:#fff}.pm-login-brand{display:flex;align-items:center;gap:11px}.pm-login-mark{display:grid;place-items:center;width:35px;height:35px;border-radius:9px;background:#fff;color:#172033;font-size:14px;font-weight:850}.pm-login-brand div:last-child{display:flex;flex-direction:column;line-height:1.2}.pm-login-brand strong{font-size:13px;font-weight:760;letter-spacing:-.01em}.pm-login-brand span{margin-top:4px;color:#aeb7c7;font-size:9px;font-weight:700;letter-spacing:.13em}.pm-login-rail-copy{margin:auto 0;max-width:300px}.pm-login-rail-copy .pm-eyebrow{color:#8faefb}.pm-login-rail-copy h2{margin:10px 0 12px;color:#fff;font-size:29px;line-height:1.14;font-weight:760;letter-spacing:-.045em}.pm-login-rail-copy p:last-child{margin:0;color:#aeb7c7;font-size:13px;line-height:1.65}.pm-login-rail-footer{display:flex;align-items:center;gap:8px;color:#8f99ab;font-size:10px;font-weight:600}.pm-login-rail-footer span{width:6px;height:6px;border-radius:50%;background:#32d583}.pm-login-main{display:flex;flex-direction:column;justify-content:center;padding:54px 68px}.pm-login-copy{margin-bottom:30px}.pm-login-copy .pm-eyebrow{margin:0 0 7px;color:#315efb;font-size:10px;font-weight:800;letter-spacing:.11em;text-transform:uppercase}.pm-login-copy h1{margin:0;color:#101828;font-size:30px;line-height:1.15;font-weight:760;letter-spacing:-.045em}.pm-login-copy p:last-child{margin:8px 0 0;color:#667085;font-size:13px}.pm-login-form{display:flex;flex-direction:column;gap:15px}.pm-login-form .fi-fo-field-wrp-label{color:#344054;font-size:11px;font-weight:700}.pm-login-form .fi-input{min-height:44px}.pm-login-options{display:flex;justify-content:flex-end;margin-top:-3px}.pm-login-options a{color:#315efb;font-size:11px;font-weight:650;text-decoration:none}.pm-login-options a:hover{text-decoration:underline}.pm-login-submit{width:100%;justify-content:center;margin-top:4px}.pm-login-submit span{margin-left:auto;font-size:16px}.pm-login-footer{margin:30px 0 0;color:#98a2b3;font-size:10px;line-height:1.5}@media(max-width:760px){.pm-login-v2{grid-template-columns:1fr;min-height:auto;border-radius:12px}.pm-login-rail{min-height:220px;padding:24px}.pm-login-rail-copy{margin:35px 0 0}.pm-login-rail-copy h2{font-size:24px}.pm-login-rail-copy p:last-child{display:none}.pm-login-main{padding:34px 24px 30px}.pm-login-copy{margin-bottom:24px}.pm-login-copy h1{font-size:26px}.pm-login-footer{margin-top:24px}}@media(max-width:480px){.pm-login-rail{padding:20px}.pm-login-main{padding:28px 18px 24px}}
    </style>
</x-filament-panels::page.simple>

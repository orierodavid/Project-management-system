<x-filament-panels::page>
    <style>
        .pm-settings-page{max-width:1080px;margin:0 auto;padding-bottom:40px}.pm-settings-intro{display:flex;justify-content:space-between;align-items:flex-end;gap:24px;margin-bottom:28px}.pm-settings-intro__eyebrow{margin:0 0 6px;color:#667085;font-size:11px;font-weight:750;letter-spacing:.1em;text-transform:uppercase}.pm-settings-intro h1{margin:0;color:#101828;font-size:30px;line-height:1.15;font-weight:760;letter-spacing:-.04em}.pm-settings-intro p{max-width:650px;margin:8px 0 0;color:#667085;font-size:14px;line-height:1.55}.pm-settings-status{display:inline-flex;align-items:center;gap:7px;padding:8px 10px;border:1px solid #e4e7ec;border-radius:8px;background:#fff;color:#475467;font-size:11px;font-weight:700;white-space:nowrap}.pm-settings-status span{width:6px;height:6px;border-radius:50%;background:#12b76a}.pm-settings-form{display:flex;flex-direction:column;gap:16px}.pm-settings-form .fi-section{border:1px solid #e4e7ec;border-radius:12px;box-shadow:0 1px 2px rgba(16,24,40,.03);overflow:hidden}.pm-settings-form .fi-section-header{padding:18px 22px;background:#fff;border-bottom:1px solid #eaecf0}.pm-settings-form .fi-section-content-ctn{padding:22px;background:#fff}.pm-settings-form .fi-section-header-icon{width:34px;height:34px;padding:8px;border:1px solid #e4e7ec;border-radius:8px;background:#f8fafc;color:#475467}.pm-settings-form .fi-section-header-heading{color:#101828;font-size:15px;font-weight:720}.pm-settings-form .fi-section-header-description{margin-top:3px;color:#667085;font-size:12px;line-height:1.5}.pm-settings-form .fi-fo-field-wrp-label{color:#344054;font-size:12px;font-weight:650}.pm-settings-form .fi-fo-field-wrp-helper-text{color:#98a2b3;font-size:11px;line-height:1.45}.pm-settings-actions{display:flex;justify-content:flex-end;padding-top:4px}.pm-settings-actions button{min-width:140px}@media(max-width:700px){.pm-settings-page{padding-bottom:24px}.pm-settings-intro{align-items:flex-start;flex-direction:column;margin-bottom:20px}.pm-settings-intro h1{font-size:25px}.pm-settings-status{display:none}.pm-settings-form .fi-section-content-ctn{padding:16px}.pm-settings-actions button{width:100%;justify-content:center}}
    </style>

    <div class="pm-settings-page">
        <header class="pm-settings-intro">
            <div>
                <p class="pm-settings-intro__eyebrow">System / Company settings</p>
                <h1>Company settings</h1>
                <p>Manage the workspace identity, visual branding, operating hours and task defaults used across the platform.</p>
            </div>
            <div class="pm-settings-status"><span></span>Configuration workspace</div>
        </header>

        <form wire:submit="save" class="pm-settings-form">
            {{ $this->form }}

            <div class="pm-settings-actions">
                <x-filament::button type="submit" icon="heroicon-o-check">
                    Save settings
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>

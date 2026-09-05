<x-filament-panels::page>
    <div class="pm-page-intro">
        <div>
            <div class="pm-eyebrow">System</div>
            <h2>Company settings</h2>
            <p>Manage the workspace identity, operating hours, and defaults used across the platform.</p>
        </div>
    </div>

    <form wire:submit="save" class="pm-settings-form">
        <div class="pm-settings-card">
            <div class="pm-settings-card__head">
                <div>
                    <h3>Workspace configuration</h3>
                    <p>Keep your organisation details and working rules up to date.</p>
                </div>
                <span class="pm-settings-icon">⚙</span>
            </div>
            <div class="pm-settings-card__body">
                {{ $this->form }}
            </div>
        </div>

        <div class="pm-settings-actions">
            <x-filament::button type="submit" icon="heroicon-o-check">
                Save settings
            </x-filament::button>
        </div>
    </form>

    <style>
        .pm-page-intro{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:24px}.pm-eyebrow{font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#667085;margin-bottom:6px}.pm-page-intro h2{margin:0;color:#101828;font-size:26px;line-height:1.2;font-weight:700;letter-spacing:-.02em}.pm-page-intro p{margin:7px 0 0;color:#667085;font-size:14px;line-height:1.6}.pm-settings-form{display:flex;flex-direction:column;gap:18px}.pm-settings-card{background:#fff;border:1px solid #e4e7ec;border-radius:12px;box-shadow:0 1px 2px rgba(16,24,40,.04);overflow:hidden}.pm-settings-card__head{display:flex;align-items:center;justify-content:space-between;padding:20px 24px;border-bottom:1px solid #e4e7ec}.pm-settings-card__head h3{margin:0;color:#101828;font-size:16px;font-weight:700}.pm-settings-card__head p{margin:5px 0 0;color:#667085;font-size:13px}.pm-settings-icon{display:grid;place-items:center;width:36px;height:36px;border:1px solid #e4e7ec;border-radius:9px;color:#475467;background:#f8fafc}.pm-settings-card__body{padding:24px}.pm-settings-actions{display:flex;justify-content:flex-end}@media(max-width:640px){.pm-page-intro h2{font-size:22px}.pm-settings-card__head,.pm-settings-card__body{padding:18px}.pm-settings-actions{justify-content:stretch}.pm-settings-actions button{width:100%;justify-content:center}}
    </style>
</x-filament-panels::page>

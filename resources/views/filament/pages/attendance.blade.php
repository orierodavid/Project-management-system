<x-filament-panels::page>
    <div x-data="attendancePage()" x-init="loadStatus()" class="pm-attendance-page">
        <header class="pm-attendance-head">
            <div>
                <p class="pm-eyebrow">MY WORK / ATTENDANCE</p>
                <h1>Attendance</h1>
                <p>Start and finish your workday securely with location verification.</p>
            </div>
            <div class="pm-today"><span></span><div><strong>{{ now()->format('l') }}</strong><small>{{ now()->format('F j, Y') }}</small></div></div>
        </header>

        <section class="pm-workday-card" :class="clockedIn ? 'is-working' : ''">
            <div class="pm-workday-main">
                <div class="pm-live-label"><span :class="clockedIn ? 'live' : ''"></span><span x-text="clockedIn ? 'WORKDAY IN PROGRESS' : 'WORKDAY READY'">WORKDAY READY</span></div>
                <h2 x-text="clockedIn ? 'You’re clocked in' : 'Start your workday'">Start your workday</h2>
                <p x-text="clockedIn ? ('You started at ' + formatDate(attendance?.clock_in_at)) : 'Confirm your location to record today’s attendance.'">Confirm your location to record today’s attendance.</p>
                <div class="pm-workday-stats">
                    <div><small>Branch</small><strong x-text="attendance?.branch?.name || '{{ auth()->user()->primaryBranch?->name ?? 'Primary branch' }}'">{{ auth()->user()->primaryBranch?->name ?? 'Primary branch' }}</strong></div>
                    <div><small>Clock in</small><strong x-text="attendance?.clock_in_at ? formatTime(attendance.clock_in_at) : '—'">—</strong></div>
                    <div><small>Status</small><strong x-text="clockedIn ? 'Working' : 'Not started'">Not started</strong></div>
                </div>
            </div>
            <div class="pm-clock-panel">
                <div class="pm-clock-ring"><div><strong x-text="clockedIn ? elapsed : '00:00'">00:00</strong><small>hours worked</small></div></div>
                <button type="button" @click="submit(clockedIn ? 'clock-out' : 'clock-in')" :disabled="busy" class="pm-clock-cta">
                    <span class="pm-clock-cta-icon">◷</span><span x-text="busy ? 'Verifying…' : (clockedIn ? 'Clock out' : 'Clock in')">Clock in</span><span>→</span>
                </button>
                <small class="pm-location-note"><span>⌖</span> Location verification required</small>
            </div>
        </section>

        <div x-show="error" x-cloak class="pm-attendance-error"><strong>Attendance could not be updated.</strong><span x-text="error"></span></div>
        <div x-show="message && attendance" x-cloak class="pm-attendance-success"><span>✓</span><span x-text="message"></span></div>

        <section class="pm-attendance-details" x-show="attendance" x-cloak>
            <div class="pm-section-heading"><div><p class="pm-eyebrow">TODAY</p><h2>Session details</h2></div><span class="pm-session-badge" x-text="attendance?.status?.replace('_', ' ') || 'Active'">Active</span></div>
            <div class="pm-detail-grid">
                <div><span>Branch</span><strong x-text="attendance?.branch?.name || '—'">—</strong><small>Assigned work location</small></div>
                <div><span>Clocked in</span><strong x-text="formatDate(attendance?.clock_in_at)">—</strong><small>Start of today’s session</small></div>
                <div><span>Clocked out</span><strong x-text="formatDate(attendance?.clock_out_at)">—</strong><small>End of today’s session</small></div>
                <div><span>Attendance status</span><strong class="capitalize" x-text="attendance?.status?.replace('_', ' ') || '—'">—</strong><small>Recorded session state</small></div>
            </div>
        </section>

        <section class="pm-attendance-help">
            <div class="pm-help-icon">⌖</div><div><strong>Location verification</strong><p>Your browser location is checked when you clock in or out. Keep location services enabled and allow access when prompted.</p></div>
        </section>
    </div>

    <script>
        function attendancePage() {
            return {
                busy: false,
                action: null,
                clockedIn: false,
                attendance: null,
                message: '',
                error: null,
                elapsed: '00:00',
                timer: null,
                async loadStatus() {
                    const response = await fetch('{{ route('attendance.status') }}', { headers: { 'Accept': 'application/json' } });
                    if (response.ok) {
                        const data = await response.json();
                        this.clockedIn = data.clocked_in;
                        this.attendance = data.attendance;
                        this.updateElapsed();
                        if (this.clockedIn && !this.timer) this.timer = setInterval(() => this.updateElapsed(), 1000);
                    }
                },
                updateElapsed() {
                    if (!this.clockedIn || !this.attendance?.clock_in_at) { this.elapsed = '00:00'; return; }
                    const seconds = Math.max(0, Math.floor((Date.now() - new Date(this.attendance.clock_in_at).getTime()) / 1000));
                    const hours = Math.floor(seconds / 3600);
                    const minutes = Math.floor((seconds % 3600) / 60);
                    const secs = seconds % 60;
                    this.elapsed = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                    this.elapsedSeconds = secs;
                },
                async submit(action) {
                    this.busy = true;
                    this.action = action;
                    this.error = null;
                    this.message = '';
                    if (!navigator.geolocation) {
                        this.error = 'Your browser does not support location services.';
                        this.busy = false;
                        return;
                    }
                    navigator.geolocation.getCurrentPosition(
                        position => this.send(action, position),
                        error => {
                            this.error = error.code === 1 ? 'Location permission was denied.' : 'Unable to determine your location. Please try again.';
                            this.busy = false;
                            this.action = null;
                        },
                        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    );
                },
                async send(action, position) {
                    const response = await fetch(`/attendance/${action}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ latitude: position.coords.latitude, longitude: position.coords.longitude, accuracy: position.coords.accuracy })
                    });
                    const data = await response.json().catch(() => ({}));
                    if (!response.ok) this.error = data.message || 'Attendance action failed.';
                    else { this.message = data.message; await this.loadStatus(); }
                    this.busy = false;
                    this.action = null;
                },
                formatDate(value) { return value ? new Date(value).toLocaleString() : '—'; },
                formatTime(value) { return value ? new Date(value).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '—'; }
            }
        }
    </script>

    <style>
        .pm-attendance-page{max-width:1180px;margin:0 auto;padding-bottom:32px}.pm-attendance-head{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:22px}.pm-attendance-head h1{margin:4px 0 6px;color:#101828;font-size:30px;line-height:1.15;font-weight:760;letter-spacing:-.04em}.pm-attendance-head>div:first-child>p:last-child{margin:0;color:#667085;font-size:14px}.pm-today{display:flex;align-items:center;gap:10px;padding:9px 12px;border:1px solid #e4e7ec;border-radius:9px;background:#fff}.pm-today>span{width:7px;height:7px;border-radius:50%;background:#12b76a}.pm-today div{display:flex;flex-direction:column;gap:2px}.pm-today strong{color:#344054;font-size:11px}.pm-today small{color:#98a2b3;font-size:10px}.pm-workday-card{display:grid;grid-template-columns:minmax(0,1fr) 310px;min-height:330px;background:#fff;border:1px solid #e4e7ec;border-radius:14px;box-shadow:0 2px 6px rgba(16,24,40,.04);overflow:hidden}.pm-workday-main{padding:34px 38px}.pm-live-label{display:flex;align-items:center;gap:7px;color:#667085;font-size:10px;font-weight:800;letter-spacing:.1em}.pm-live-label>span:first-child{width:6px;height:6px;border-radius:50%;background:#98a2b3}.pm-live-label>span:first-child.live{background:#12b76a;box-shadow:0 0 0 4px #ecfdf3}.pm-workday-main h2{margin:18px 0 7px;color:#101828;font-size:32px;line-height:1.1;font-weight:760;letter-spacing:-.045em}.pm-workday-main>p{max-width:520px;margin:0;color:#667085;font-size:13px;line-height:1.55}.pm-workday-card.is-working .pm-workday-main h2{color:#027a48}.pm-workday-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:0;max-width:620px;margin-top:42px;padding-top:18px;border-top:1px solid #eef0f3}.pm-workday-stats div{display:flex;flex-direction:column;gap:5px;padding-right:20px}.pm-workday-stats div+div{padding-left:20px;border-left:1px solid #eef0f3}.pm-workday-stats small,.pm-detail-grid span{color:#98a2b3;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em}.pm-workday-stats strong{color:#344054;font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.pm-clock-panel{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:28px;background:#f8fafc;border-left:1px solid #e4e7ec}.pm-clock-ring{display:grid;place-items:center;width:142px;height:142px;border:1px solid #d0d5dd;border-radius:50%;background:#fff;box-shadow:inset 0 0 0 8px #f8fafc}.pm-clock-ring>div{text-align:center}.pm-clock-ring strong{display:block;color:#101828;font-size:25px;line-height:1;font-weight:760;letter-spacing:-.04em}.pm-clock-ring small{display:block;margin-top:7px;color:#98a2b3;font-size:9px}.pm-clock-cta{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;min-height:44px;margin-top:20px;padding:0 15px;border:0;border-radius:8px;background:#175cd3;color:#fff;font-size:12px;font-weight:750;cursor:pointer;box-shadow:0 2px 4px rgba(16,24,40,.1)}.pm-clock-cta:hover{background:#1849a9}.pm-clock-cta:disabled{opacity:.6;cursor:not-allowed}.pm-clock-cta>span:last-child{margin-left:auto}.pm-clock-cta-icon{font-size:17px}.pm-location-note{margin-top:10px;color:#98a2b3;font-size:9px}.pm-location-note span{margin-right:4px}.pm-attendance-error,.pm-attendance-success{display:flex;align-items:center;gap:8px;margin-top:14px;padding:11px 13px;border-radius:8px;font-size:11px}.pm-attendance-error{border:1px solid #fecdca;background:#fffbfa;color:#b42318}.pm-attendance-error strong{font-weight:750}.pm-attendance-success{border:1px solid #abefc6;background:#f6fef9;color:#027a48}.pm-attendance-details{margin-top:18px;background:#fff;border:1px solid #e4e7ec;border-radius:12px;box-shadow:0 1px 2px rgba(16,24,40,.03)}.pm-section-heading{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid #eef0f3}.pm-section-heading h2{margin:3px 0 0;color:#101828;font-size:17px;font-weight:720}.pm-session-badge{padding:5px 8px;border-radius:6px;background:#ecfdf3;color:#027a48;font-size:10px;font-weight:750;text-transform:capitalize}.pm-detail-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));padding:4px}.pm-detail-grid>div{display:flex;flex-direction:column;gap:6px;padding:17px 16px}.pm-detail-grid strong{color:#344054;font-size:12px;font-weight:700}.pm-detail-grid small{color:#98a2b3;font-size:10px}.pm-attendance-help{display:flex;align-items:flex-start;gap:12px;margin-top:18px;padding:15px 17px;border:1px solid #e4e7ec;border-radius:10px;background:#fff}.pm-help-icon{display:grid;place-items:center;width:30px;height:30px;flex:0 0 30px;border-radius:7px;background:#eff8ff;color:#175cd3;font-size:14px}.pm-attendance-help strong{display:block;color:#344054;font-size:12px}.pm-attendance-help p{margin:3px 0 0;color:#667085;font-size:10px;line-height:1.5}.capitalize{text-transform:capitalize}@media(max-width:850px){.pm-workday-card{grid-template-columns:1fr}.pm-clock-panel{border-top:1px solid #e4e7ec;border-left:0}.pm-detail-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:600px){.pm-attendance-page{padding-bottom:20px}.pm-attendance-head{align-items:flex-start;flex-direction:column}.pm-attendance-head h1{font-size:25px}.pm-today{display:none}.pm-workday-main{padding:22px}.pm-workday-main h2{font-size:27px}.pm-workday-stats{grid-template-columns:1fr;gap:13px;margin-top:28px}.pm-workday-stats div,.pm-workday-stats div+div{padding:0;border:0}.pm-clock-panel{padding:24px 20px}.pm-detail-grid{grid-template-columns:1fr}.pm-section-heading{padding:16px}.pm-attendance-help{padding:13px}}
    </style>
</x-filament-panels::page>

<x-filament-panels::page>
    <style>
        .pm-admin-page{max-width:1440px;margin:0 auto;padding-bottom:32px}.pm-page-intro{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin:0 0 24px}.pm-page-title{margin:4px 0 6px;color:#101828;font-size:30px;line-height:1.15;font-weight:760;letter-spacing:-.04em}.pm-page-subtitle{margin:0;color:#667085;font-size:14px;line-height:1.5}.pm-page-meta{display:flex;align-items:center;gap:8px;color:#475467;font-size:12px;font-weight:650;white-space:nowrap}.pm-status-dot{width:7px;height:7px;border-radius:50%;background:#22c55e}.pm-kpi-grid-4{grid-template-columns:repeat(4,minmax(0,1fr))!important}.pm-kpi-card{display:flex;flex-direction:column;min-height:118px;padding:18px 20px;background:#fff;border:1px solid #e4e7ec;border-radius:12px;box-shadow:0 1px 2px rgba(16,24,40,.03)}.pm-kpi-label{color:#667085;font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase}.pm-kpi-value{margin-top:8px;color:#101828;font-size:28px;line-height:1;font-weight:760;letter-spacing:-.035em}.pm-kpi-note{margin-top:auto;color:#98a2b3;font-size:11px}.pm-note-positive{color:#039855}.pm-note-warning{color:#b54708}.pm-filter-panel{margin-top:18px}.pm-filter-panel .pm-panel-heading{padding:19px 22px}.pm-panel-heading h2{margin:0;color:#101828;font-size:17px;font-weight:720;letter-spacing:-.02em}.pm-panel-heading p{margin:4px 0 0;color:#667085;font-size:12px}.pm-record-count{padding:6px 9px;border:1px solid #e4e7ec;border-radius:6px;background:#f9fafb;color:#475467;font-size:11px;font-weight:700}.pm-report-form{padding:20px 22px 18px}.pm-report-actions{display:flex;justify-content:flex-end;margin-top:18px}.pm-table-panel{margin-top:18px}.pm-table-scroll{overflow-x:auto}.pm-data-table{width:100%;border-collapse:collapse;text-align:left;font-size:13px}.pm-data-table th{padding:12px 18px;border-bottom:1px solid #e4e7ec;background:#f9fafb;color:#667085;font-size:10px;font-weight:750;letter-spacing:.08em;text-transform:uppercase;white-space:nowrap}.pm-data-table td{padding:14px 18px;border-bottom:1px solid #f0f2f5;color:#475467;vertical-align:middle;white-space:nowrap}.pm-data-table tbody tr:hover{background:#fafbfc}.pm-data-table tbody tr:last-child td{border-bottom:0}.pm-data-table td strong{color:#344054;font-weight:650}.pm-person-cell{display:flex;align-items:center;gap:10px;min-width:190px}.pm-avatar{display:grid;place-items:center;width:32px;height:32px;flex:0 0 32px;border-radius:8px;background:#eff4ff;color:#175cd3;font-size:11px;font-weight:800}.pm-person-cell div{display:flex;flex-direction:column;gap:2px;min-width:0}.pm-person-cell div strong{overflow:hidden;text-overflow:ellipsis;max-width:180px}.pm-person-cell div span,.pm-table-secondary{display:block;color:#98a2b3;font-size:10px}.pm-table-secondary{margin-top:2px}.pm-duration{color:#101828!important;font-weight:700}.pm-badge{display:inline-flex;align-items:center;gap:5px;padding:5px 8px;border-radius:6px;font-size:10px;font-weight:750;letter-spacing:.02em}.pm-badge-working{background:#ecfdf3;color:#027a48}.pm-badge-working span{width:5px;height:5px;border-radius:50%;background:#12b76a}.pm-badge-success{background:#ecfdf3;color:#027a48}.pm-badge-warning{background:#fffaeb;color:#b54708}.pm-empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;min-height:190px;text-align:center}.pm-empty-icon{display:grid;place-items:center;width:36px;height:36px;margin-bottom:4px;border-radius:9px;background:#ecfdf3;color:#027a48;font-weight:800}.pm-empty-state strong{color:#344054;font-size:13px}.pm-empty-state span{max-width:340px;color:#98a2b3;font-size:11px;line-height:1.5}@media(max-width:1000px){.pm-kpi-grid-4{grid-template-columns:repeat(2,minmax(0,1fr))!important}}@media(max-width:700px){.pm-page-intro{align-items:flex-start;flex-direction:column}.pm-page-title{font-size:25px}.pm-page-meta{display:none}.pm-kpi-grid-4{grid-template-columns:1fr!important}.pm-panel-heading{align-items:flex-start;gap:12px;flex-direction:column}.pm-report-form{padding:16px}.pm-report-form .fi-fo-component-ctn{grid-template-columns:1fr!important}.pm-data-table th,.pm-data-table td{padding:12px}.pm-person-cell{min-width:170px}}
    </style>

    @php($summary = $this->getSummary())

    <div class="pm-admin-page">
        <div class="pm-page-intro">
            <div>
                <p class="pm-eyebrow">People / Attendance</p>
                <h1 class="pm-page-title">Attendance overview</h1>
                <p class="pm-page-subtitle">Monitor attendance, active work sessions and exceptions across your permitted branches.</p>
            </div>
            <div class="pm-page-meta"><span class="pm-status-dot"></span>Live operational data</div>
        </div>

        <div class="pm-kpi-grid pm-kpi-grid-4">
            <div class="pm-kpi-card"><div class="pm-kpi-label">Attendance records</div><div class="pm-kpi-value">{{ number_format($summary['records']) }}</div><div class="pm-kpi-note">Within selected period</div></div>
            <div class="pm-kpi-card"><div class="pm-kpi-label">Currently working</div><div class="pm-kpi-value">{{ number_format($summary['working']) }}</div><div class="pm-kpi-note pm-note-positive">Open work sessions</div></div>
            <div class="pm-kpi-card"><div class="pm-kpi-label">Completed</div><div class="pm-kpi-value">{{ number_format($summary['completed']) }}</div><div class="pm-kpi-note">Clocked out sessions</div></div>
            <div class="pm-kpi-card"><div class="pm-kpi-label">Late arrivals</div><div class="pm-kpi-value">{{ number_format($summary['late']) }}</div><div class="pm-kpi-note {{ $summary['late'] ? 'pm-note-warning' : 'pm-note-positive' }}">{{ $summary['late'] ? 'Needs attention' : 'No exceptions' }}</div></div>
        </div>

        <section class="pm-panel pm-filter-panel">
            <div class="pm-panel-heading"><div><h2>Attendance records</h2><p>Filter the operational view by period, branch, employee or attendance status.</p></div><span class="pm-record-count">{{ number_format($summary['records']) }} records</span></div>
            <form wire:submit="export" class="pm-report-form">
                {{ $this->form }}
                <div class="pm-report-actions"><x-filament::button type="submit" icon="heroicon-o-arrow-down-tray">Export Excel</x-filament::button></div>
            </form>
        </section>

        <section class="pm-panel pm-table-panel">
            <div class="pm-table-scroll">
                <table class="pm-data-table">
                    <thead><tr><th>Employee</th><th>Branch</th><th>Clock in</th><th>Clock out</th><th>Duration</th><th>Status</th><th>Late</th></tr></thead>
                    <tbody>
                        @forelse ($this->getRecords() as $record)
                            <tr>
                                <td><div class="pm-person-cell"><span class="pm-avatar">{{ strtoupper(substr($record->user?->name ?? '?', 0, 1)) }}</span><div><strong>{{ $record->user?->name ?? 'Unknown employee' }}</strong><span>{{ $record->user?->email ?? '—' }}</span></div></div></td>
                                <td>{{ $record->branch?->name ?? '—' }}</td>
                                <td><strong>{{ $record->clock_in_at?->format('d M Y') ?? '—' }}</strong><span class="pm-table-secondary">{{ $record->clock_in_at?->format('H:i') ?? '' }}</span></td>
                                <td>{{ $record->clock_out_at?->format('d M Y') ?? '—' }}<span class="pm-table-secondary">{{ $record->clock_out_at?->format('H:i') ?? ($record->clock_in_at ? 'Still working' : '') }}</span></td>
                                <td class="pm-duration">{{ $this->getDuration($record) }}</td>
                                <td>@if (is_null($record->clock_out_at))<span class="pm-badge pm-badge-working"><span></span> Working</span>@elseif ($record->status === 'late')<span class="pm-badge pm-badge-warning">Late</span>@else<span class="pm-badge pm-badge-success">On time</span>@endif</td>
                                <td>{{ $record->late_minutes ? $record->late_minutes . ' min' : '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7"><div class="pm-empty-state"><div class="pm-empty-icon">✓</div><strong>No attendance records</strong><span>No records match the current filters. Adjust the date range or filters and try again.</span></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-filament-panels::page>

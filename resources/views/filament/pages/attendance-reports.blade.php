<x-filament-panels::page>
    @php($summary = $this->getSummary())

    <div class="pm-admin-page">
        <div class="pm-page-intro">
            <div>
                <p class="pm-eyebrow">People / Attendance</p>
                <h1 class="pm-page-title">Attendance overview</h1>
                <p class="pm-page-subtitle">Monitor attendance, active work sessions and exceptions across your permitted branches.</p>
            </div>
            <div class="pm-page-meta">
                <span class="pm-status-dot"></span>
                Live operational data
            </div>
        </div>

        <div class="pm-kpi-grid pm-kpi-grid-4">
            <div class="pm-kpi-card">
                <div class="pm-kpi-label">Attendance records</div>
                <div class="pm-kpi-value">{{ number_format($summary['records']) }}</div>
                <div class="pm-kpi-note">Within selected period</div>
            </div>
            <div class="pm-kpi-card">
                <div class="pm-kpi-label">Currently working</div>
                <div class="pm-kpi-value">{{ number_format($summary['working']) }}</div>
                <div class="pm-kpi-note pm-note-positive">Open work sessions</div>
            </div>
            <div class="pm-kpi-card">
                <div class="pm-kpi-label">Completed</div>
                <div class="pm-kpi-value">{{ number_format($summary['completed']) }}</div>
                <div class="pm-kpi-note">Clocked out sessions</div>
            </div>
            <div class="pm-kpi-card">
                <div class="pm-kpi-label">Late arrivals</div>
                <div class="pm-kpi-value">{{ number_format($summary['late']) }}</div>
                <div class="pm-kpi-note {{ $summary['late'] ? 'pm-note-warning' : 'pm-note-positive' }}">{{ $summary['late'] ? 'Needs attention' : 'No exceptions' }}</div>
            </div>
        </div>

        <section class="pm-panel pm-filter-panel">
            <div class="pm-panel-heading">
                <div>
                    <h2>Attendance records</h2>
                    <p>Filter the operational view by period, branch, employee or attendance status.</p>
                </div>
                <span class="pm-record-count">{{ number_format($summary['records']) }} records</span>
            </div>
            <form wire:submit="export" class="pm-report-form">
                {{ $this->form }}
                <div class="pm-report-actions">
                    <x-filament::button type="submit" icon="heroicon-o-arrow-down-tray">
                        Export Excel
                    </x-filament::button>
                </div>
            </form>
        </section>

        <section class="pm-panel pm-table-panel">
            <div class="pm-table-scroll">
                <table class="pm-data-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Branch</th>
                            <th>Clock in</th>
                            <th>Clock out</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Late</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->getRecords() as $record)
                            <tr>
                                <td>
                                    <div class="pm-person-cell">
                                        <span class="pm-avatar">{{ strtoupper(substr($record->user?->name ?? '?', 0, 1)) }}</span>
                                        <div>
                                            <strong>{{ $record->user?->name ?? 'Unknown employee' }}</strong>
                                            <span>{{ $record->user?->email ?? '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $record->branch?->name ?? '—' }}</td>
                                <td><strong>{{ $record->clock_in_at?->format('d M Y') ?? '—' }}</strong><span class="pm-table-secondary">{{ $record->clock_in_at?->format('H:i') ?? '' }}</span></td>
                                <td>{{ $record->clock_out_at?->format('d M Y') ?? '—' }}<span class="pm-table-secondary">{{ $record->clock_out_at?->format('H:i') ?? ($record->clock_in_at ? 'Still working' : '') }}</span></td>
                                <td class="pm-duration">{{ $this->getDuration($record) }}</td>
                                <td>
                                    @if (is_null($record->clock_out_at))
                                        <span class="pm-badge pm-badge-working"><span></span> Working</span>
                                    @elseif ($record->status === 'late')
                                        <span class="pm-badge pm-badge-warning">Late</span>
                                    @else
                                        <span class="pm-badge pm-badge-success">On time</span>
                                    @endif
                                </td>
                                <td>{{ $record->late_minutes ? $record->late_minutes . ' min' : '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="pm-empty-state">
                                        <div class="pm-empty-icon">✓</div>
                                        <strong>No attendance records</strong>
                                        <span>No records match the current filters. Adjust the date range or filters and try again.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-filament-panels::page>

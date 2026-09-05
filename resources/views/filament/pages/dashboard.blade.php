<x-filament-panels::page>
    @php($isStaff = $mode === 'staff')

    <div class="pm-dashboard" x-data="dashboardAttendance()" x-init="loadStatus()">
        <header class="pm-dashboard-header">
            <div>
                <p class="pm-eyebrow">{{ $isStaff ? 'My workspace' : 'Command center' }}</p>
                <h1>{{ $isStaff ? 'Good morning, ' . auth()->user()->name : 'Good morning, Admin' }} <span aria-hidden="true">👋</span></h1>
                <p>{{ $isStaff ? "Here’s what needs your attention today." : "A live view of people, delivery and attendance across your workspace." }}</p>
            </div>
            <div class="pm-header-actions">
                @if (! $isStaff)
                    <a class="pm-dashboard-action" href="{{ \App\Filament\Pages\AttendanceReports::getUrl() }}">View reports <span>↗</span></a>
                @endif
                <div class="pm-header-date"><span class="pm-date-dot"></span>{{ now()->format('l, F j') }}</div>
            </div>
        </header>

        @if ($isStaff)
            <section class="pm-attendance-hero" :class="clockedIn ? 'is-working' : ''">
                <div class="pm-attendance-copy">
                    <div class="pm-status-line"><span class="pm-live-dot" :class="clockedIn ? 'is-live' : ''"></span><span x-text="clockedIn ? 'YOU ARE WORKING' : 'TODAY’S ATTENDANCE'"></span></div>
                    <h2 x-text="clockedIn ? 'You’re clocked in' : 'Start your workday'">Start your workday</h2>
                    <p x-text="clockedIn ? ('Clocked in at ' + clockInTime) : 'Clock in to start tracking your attendance securely.'">Clock in to start tracking your attendance securely.</p>
                    <div class="pm-attendance-meta"><span><strong x-text="clockedIn ? elapsed : '—'">—</strong><small>worked today</small></span><span><strong x-text="branchName">{{ auth()->user()->primaryBranch?->name ?? 'Primary branch' }}</strong><small>assigned branch</small></span></div>
                </div>
                <div class="pm-attendance-action"><button type="button" class="pm-clock-button" @click="submit(clockedIn ? 'clock-out' : 'clock-in')" :disabled="busy"><span class="pm-clock-icon" aria-hidden="true">◷</span><span x-text="busy ? 'Verifying location…' : (clockedIn ? 'Clock out' : 'Clock in')">Clock in</span><span class="pm-button-arrow" aria-hidden="true">→</span></button><small><span aria-hidden="true">⌖</span> Location verification required</small></div>
            </section>

            <div x-show="error" x-cloak class="pm-inline-error" x-text="error"></div>
            <section class="pm-kpi-grid">
                <a class="pm-kpi" href="{{ url('/staff/tasks') }}"><span class="pm-kpi-label">Open tasks</span><strong>{{ $taskCount }}</strong><span class="pm-kpi-note">{{ $completedCount }} completed</span></a>
                <a class="pm-kpi" href="{{ url('/staff/tasks') }}"><span class="pm-kpi-label">Due soon</span><strong>{{ $dueSoonCount }}</strong><span class="pm-kpi-note">Next 48 hours</span></a>
                <a class="pm-kpi" href="{{ url('/staff/attendance') }}"><span class="pm-kpi-label">Attendance</span><strong x-text="clockedIn ? 'Active' : 'Ready'">Ready</strong><span class="pm-kpi-note">Secure location check</span></a>
            </section>
            <div class="pm-content-grid">
                <section class="pm-panel pm-tasks-panel"><div class="pm-panel-heading"><div><p class="pm-eyebrow">Priority queue</p><h2>My tasks</h2></div><a href="{{ url('/staff/tasks') }}">View all <span>→</span></a></div><div class="pm-task-list">@forelse ($tasks as $task)<div class="pm-task-row"><div class="pm-task-marker {{ $task->status === 'done' ? 'done' : '' }}"></div><div class="pm-task-main"><strong>{{ $task->title }}</strong><span>{{ $task->deadline ? 'Due ' . $task->deadline->format('M j, Y') : 'No deadline' }}</span></div><span class="pm-priority priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span></div>@empty<div class="pm-empty"><strong>No tasks assigned</strong><span>You’re all clear for now.</span></div>@endforelse</div></section>
                <section class="pm-panel pm-focus-panel"><p class="pm-eyebrow">Today at a glance</p><h2>Keep your momentum.</h2><p>Stay on top of your tasks and keep attendance accurate throughout the day.</p><div class="pm-focus-rule"></div><a class="pm-text-action" href="{{ url('/staff/attendance') }}">Open attendance history <span>→</span></a></section>
            </div>
        @else
            <section class="pm-admin-kpi-grid">
                <div class="pm-kpi pm-kpi-primary"><span class="pm-kpi-label">Active people</span><strong>{{ $userCount }}</strong><span class="pm-kpi-note">People currently active</span><span class="pm-kpi-trend">Workspace</span></div>
                <div class="pm-kpi"><span class="pm-kpi-label">Open tasks</span><strong>{{ $taskCount }}</strong><span class="pm-kpi-note">Work still in progress</span></div>
                <div class="pm-kpi"><span class="pm-kpi-label">Overdue</span><strong>{{ $overdueCount }}</strong><span class="pm-kpi-note">Requires attention</span></div>
                <div class="pm-kpi"><span class="pm-kpi-label">Present today</span><strong>{{ $presentCount }}</strong><span class="pm-kpi-note">Attendance check-ins</span></div>
            </section>

            <section class="pm-analytics-grid">
                <article class="pm-panel pm-chart-panel pm-attendance-chart">
                    <div class="pm-chart-heading"><div><p class="pm-eyebrow">Attendance</p><h2>Weekly attendance</h2><span>Check-ins over the last 7 days</span></div><a href="{{ \App\Filament\Pages\AttendanceReports::getUrl() }}">Full report <span>↗</span></a></div>
                    <div class="pm-bar-chart" role="img" aria-label="Weekly attendance chart">
                        @php($maxAttendance = max(1, collect($attendanceTrend)->max('count')))
                        @foreach ($attendanceTrend as $day)
                            <div class="pm-bar-item"><div class="pm-bar-value">{{ $day['count'] }}</div><div class="pm-bar-track"><div class="pm-bar-fill" style="height: {{ max(8, ($day['count'] / $maxAttendance) * 100) }}%"></div></div><strong>{{ $day['label'] }}</strong><small>{{ $day['date'] }}</small></div>
                        @endforeach
                    </div>
                </article>

                <article class="pm-panel pm-chart-panel pm-pipeline-chart">
                    <div class="pm-chart-heading"><div><p class="pm-eyebrow">Delivery</p><h2>Task pipeline</h2><span>Current work by status</span></div><a href="{{ \App\Filament\Resources\TaskResource::getUrl('board') }}">Open board <span>↗</span></a></div>
                    @php($pipelineTotal = max(1, collect($taskPipeline)->sum('count')))
                    <div class="pm-pipeline-list">
                        @foreach ($taskPipeline as $item)
                            <div class="pm-pipeline-row"><div class="pm-pipeline-label"><span>{{ $item['label'] }}</span><strong>{{ $item['count'] }}</strong></div><div class="pm-pipeline-track"><span style="width: {{ ($item['count'] / $pipelineTotal) * 100 }}%"></span></div></div>
                        @endforeach
                    </div>
                    <div class="pm-pipeline-total"><strong>{{ $pipelineTotal }}</strong><span>Total tracked tasks</span></div>
                </article>
            </section>

            <section class="pm-report-strip">
                <div><span class="pm-report-icon">▦</span><div><strong>Attendance & workforce reports</strong><span>Review employee attendance, late arrivals, working hours and branch performance.</span></div></div>
                <a href="{{ \App\Filament\Pages\AttendanceReports::getUrl() }}">Open reporting workspace <span>→</span></a>
            </section>

            <div class="pm-content-grid admin-grid">
                <section class="pm-panel pm-tasks-panel"><div class="pm-panel-heading"><div><p class="pm-eyebrow">Workspace activity</p><h2>Recent tasks</h2></div><a href="{{ url('/admin/tasks') }}">View all <span>→</span></a></div><div class="pm-task-list">@forelse ($recentTasks as $task)<div class="pm-task-row"><div class="pm-task-marker {{ $task->status === 'done' ? 'done' : '' }}"></div><div class="pm-task-main"><strong>{{ $task->title }}</strong><span>{{ $task->assignee?->name ?? 'Unassigned' }}</span></div><span class="pm-status-chip">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span></div>@empty<div class="pm-empty"><strong>No recent tasks</strong><span>Task activity will appear here.</span></div>@endforelse</div></section>
                <section class="pm-panel pm-focus-panel"><p class="pm-eyebrow">Management shortcuts</p><h2>Move work forward.</h2><p>Go directly to the areas that need your attention.</p><div class="pm-quick-links"><a href="{{ url('/admin/users') }}">People <span>→</span></a><a href="{{ url('/admin/attendance') }}">Attendance <span>→</span></a><a href="{{ \App\Filament\Resources\TaskResource::getUrl('board') }}">Task board <span>→</span></a><a href="{{ \App\Filament\Pages\AttendanceReports::getUrl() }}">Reports <span>→</span></a></div></section>
            </div>
        @endif
    </div>

    <style>
        .pm-header-actions{display:flex;align-items:center;gap:16px}.pm-dashboard-action{display:inline-flex;align-items:center;gap:7px;min-height:36px;padding:0 12px;border:1px solid var(--pm-border-strong);border-radius:8px;background:#fff;color:#344054;text-decoration:none;font-size:12px;font-weight:700}.pm-dashboard-action:hover{border-color:#98a2b3;color:var(--pm-accent)}
        .pm-kpi-trend{display:inline-flex;align-self:flex-start;margin-top:8px;padding:3px 7px;border-radius:5px;background:#eff8ff;color:#175cd3;font-size:10px;font-weight:750}
        .pm-analytics-grid{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(340px,.85fr);gap:18px;margin-bottom:18px}.pm-chart-panel{padding:0}.pm-chart-heading{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;padding:20px 22px 16px;border-bottom:1px solid var(--pm-border)}.pm-chart-heading h2{margin:4px 0 3px;color:var(--pm-ink);font-size:18px;font-weight:720;letter-spacing:-.02em}.pm-chart-heading span{color:var(--pm-muted);font-size:11px}.pm-chart-heading>a{color:var(--pm-accent);font-size:11px;font-weight:750;text-decoration:none;white-space:nowrap}.pm-bar-chart{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));align-items:end;gap:14px;height:245px;padding:18px 22px 20px}.pm-bar-item{display:grid;grid-template-rows:18px 1fr 18px 16px;min-width:0;height:100%;align-items:end;text-align:center}.pm-bar-value{color:#475467;font-size:10px;font-weight:700}.pm-bar-track{display:flex;align-items:flex-end;justify-content:center;height:100%;padding:0 7px;border-bottom:1px solid #eef0f3;background:repeating-linear-gradient(to top,#fff 0,#fff 45px,#f5f6f8 46px,#fff 47px)}.pm-bar-fill{width:min(34px,70%);min-height:8px;border-radius:5px 5px 2px 2px;background:#2563eb}.pm-bar-item strong{color:#344054;font-size:11px}.pm-bar-item small{color:#98a2b3;font-size:9px}.pm-pipeline-list{padding:20px 22px 8px}.pm-pipeline-row{margin-bottom:19px}.pm-pipeline-label{display:flex;justify-content:space-between;margin-bottom:7px;color:#475467;font-size:12px}.pm-pipeline-label strong{color:#101828}.pm-pipeline-track{height:8px;border-radius:4px;background:#eef1f5;overflow:hidden}.pm-pipeline-track span{display:block;height:100%;min-width:4px;border-radius:4px;background:#2563eb}.pm-pipeline-row:nth-child(2) .pm-pipeline-track span{background:#7c3aed}.pm-pipeline-row:nth-child(3) .pm-pipeline-track span{background:#f59e0b}.pm-pipeline-row:nth-child(4) .pm-pipeline-track span{background:#16a34a}.pm-pipeline-total{display:flex;align-items:baseline;gap:8px;margin:8px 22px 20px;padding-top:14px;border-top:1px solid var(--pm-border)}.pm-pipeline-total strong{color:var(--pm-ink);font-size:22px}.pm-pipeline-total span{color:var(--pm-muted);font-size:11px}
        .pm-report-strip{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:18px;padding:16px 20px;background:#fff;border:1px solid var(--pm-border);border-radius:12px;box-shadow:0 1px 2px rgba(16,24,40,.03)}.pm-report-strip>div{display:flex;align-items:center;gap:13px;min-width:0}.pm-report-icon{display:grid;place-items:center;width:38px;height:38px;border-radius:8px;background:#eff8ff;color:#2563eb;font-size:18px;font-weight:800}.pm-report-strip strong{display:block;color:#344054;font-size:13px}.pm-report-strip div div span{display:block;margin-top:2px;color:#667085;font-size:11px}.pm-report-strip>a{color:#2563eb;font-size:11px;font-weight:750;text-decoration:none;white-space:nowrap}
        @media(max-width:1100px){.pm-analytics-grid{grid-template-columns:1fr}.pm-admin-kpi-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:700px){.pm-dashboard{padding-bottom:20px}.pm-dashboard-header{align-items:flex-start;flex-direction:column;margin-bottom:18px}.pm-dashboard-header h1{font-size:25px}.pm-header-actions{width:100%;justify-content:space-between;gap:10px}.pm-header-date{font-size:11px}.pm-dashboard-action{font-size:11px}.pm-admin-kpi-grid{grid-template-columns:1fr 1fr;gap:10px}.pm-kpi{min-height:112px;padding:15px}.pm-kpi strong{font-size:24px}.pm-analytics-grid{gap:12px}.pm-chart-heading{padding:16px;gap:10px}.pm-chart-heading h2{font-size:16px}.pm-bar-chart{height:210px;gap:7px;padding:15px 10px 16px}.pm-bar-track{padding:0 3px}.pm-bar-fill{width:26px}.pm-report-strip{align-items:flex-start;flex-direction:column;padding:15px}.pm-report-strip>a{padding-left:51px}.pm-content-grid{grid-template-columns:1fr!important}.pm-task-row{padding:13px 15px}.pm-status-chip{font-size:9px}.pm-focus-panel{padding:18px}}
        @media(max-width:480px){.pm-admin-kpi-grid{grid-template-columns:1fr}.pm-kpi{min-height:100px}.pm-bar-chart{height:190px}.pm-bar-item small{font-size:8px}.pm-chart-heading>a{font-size:10px}.pm-chart-heading span{font-size:10px}.pm-report-strip>div{align-items:flex-start}.pm-report-strip>a{padding-left:0}.pm-dashboard-action{min-height:34px}}
    </style>

    <script>
        function dashboardAttendance(){return{busy:false,clockedIn:false,error:null,clockInAt:null,elapsed:'—',branchName:@js(auth()->user()->primaryBranch?->name??'Primary branch'),get clockInTime(){return this.clockInAt?new Date(this.clockInAt).toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'}):'—'},async loadStatus(){try{const response=await fetch('{{ route('attendance.status') }}',{headers:{Accept:'application/json'}});if(!response.ok)return;const data=await response.json();this.clockedIn=!!data.clocked_in;this.clockInAt=data.attendance?.clock_in_at||null;this.branchName=data.attendance?.branch?.name||this.branchName;this.updateElapsed()}catch(e){}},updateElapsed(){if(!this.clockedIn||!this.clockInAt){this.elapsed='—';return}const seconds=Math.max(0,Math.floor((Date.now()-new Date(this.clockInAt).getTime())/1000));const h=Math.floor(seconds/3600),m=Math.floor(seconds%3600/60);this.elapsed=`${String(h).padStart(2,'0')}h ${String(m).padStart(2,'0')}m`;setTimeout(()=>this.updateElapsed(),60000)},submit(action){this.busy=true;this.error=null;if(!navigator.geolocation){this.error='Your browser does not support location services.';this.busy=false;return}navigator.geolocation.getCurrentPosition(position=>this.send(action,position),error=>{this.error=error.code===1?'Location permission was denied.':'Unable to determine your location. Please try again.';this.busy=false},{enableHighAccuracy:true,timeout:15000,maximumAge:0})},async send(action,position){try{const response=await fetch(`/attendance/${action}`,{method:'POST',headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||''},body:JSON.stringify({latitude:position.coords.latitude,longitude:position.coords.longitude,accuracy:position.coords.accuracy})});const data=await response.json().catch(()=>({}));if(!response.ok){this.error=data.message||'Attendance action failed.'}else{await this.loadStatus()}}catch(e){this.error='Unable to complete the attendance action. Please try again.'}finally{this.busy=false}}}}
    </script>
</x-filament-panels::page>

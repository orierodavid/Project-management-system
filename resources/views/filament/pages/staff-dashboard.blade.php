<x-filament-panels::page>
    <div class="pm-dashboard pm-staff-dashboard" x-data="dashboardAttendance()" x-init="loadStatus()">
        <header class="pm-dashboard-header">
            <div class="pm-dashboard-heading">
                <p class="pm-eyebrow">My workspace</p>
                <h1>Good morning, {{ $currentUser->name }} <span aria-hidden="true">👋</span></h1>
                <p>Your personal overview of tasks, progress and attendance.</p>
            </div>
            <div class="pm-header-actions">
                <a class="pm-dashboard-action" href="{{ \App\Filament\Resources\TaskResource::getUrl('create', panel: 'staff') }}">Create task <span>+</span></a>
                <div class="pm-header-date"><span class="pm-date-dot"></span>{{ now()->format('l, F j') }}</div>
            </div>
        </header>

        <section class="pm-attendance-hero" :class="clockedIn ? 'is-working' : ''">
            <div class="pm-attendance-copy">
                <div class="pm-status-line"><span class="pm-live-dot" :class="clockedIn ? 'is-live' : ''"></span><span x-text="clockedIn ? 'YOU ARE WORKING' : 'TODAY’S ATTENDANCE'">TODAY’S ATTENDANCE</span></div>
                <h2 x-text="clockedIn ? 'You’re clocked in' : 'Start your workday'">Start your workday</h2>
                <p x-text="clockedIn ? ('Clocked in at ' + clockInTime) : 'Clock in to start tracking your attendance securely.'">Clock in to start tracking your attendance securely.</p>
                <div class="pm-attendance-meta"><span><strong x-text="clockedIn ? elapsed : '—'">—</strong><small>worked today</small></span><span><strong>{{ $currentUser->primaryBranch?->name ?? 'Primary branch' }}</strong><small>assigned branch</small></span></div>
            </div>
            <div class="pm-attendance-action"><button type="button" class="pm-clock-button" @click="submit(clockedIn ? 'clock-out' : 'clock-in')" :disabled="busy"><span class="pm-clock-icon" aria-hidden="true">◷</span><span x-text="busy ? 'Verifying location…' : (clockedIn ? 'Clock out' : 'Clock in')">Clock in</span><span class="pm-button-arrow" aria-hidden="true">→</span></button><small><span aria-hidden="true">⌖</span> Location verification required</small></div>
        </section>
        <div x-show="error" x-cloak class="pm-inline-error" x-text="error"></div>

        <section class="pm-kpi-grid">
            <a class="pm-kpi" href="{{ \App\Filament\Resources\TaskResource::getUrl('index', panel: 'staff') }}"><span class="pm-kpi-label">Open tasks</span><strong>{{ $taskCount }}</strong><span class="pm-kpi-note">Tasks requiring your attention · View tasks →</span></a>
            <a class="pm-kpi" href="{{ \App\Filament\Resources\TaskResource::getUrl('create', panel: 'staff') }}"><span class="pm-kpi-label">Create a task</span><strong>+</strong><span class="pm-kpi-note">Plan a new piece of work →</span></a>
            <a class="pm-kpi" href="{{ \App\Filament\Resources\TaskResource::getUrl('index', panel: 'staff') }}"><span class="pm-kpi-label">Due soon</span><strong>{{ $dueSoonCount }}</strong><span class="pm-kpi-note">Next 48 hours · Review →</span></a>
            <a class="pm-kpi" href="{{ url('/staff/attendance') }}"><span class="pm-kpi-label">Completed</span><strong>{{ $completedCount }}</strong><span class="pm-kpi-note">Tasks finished · Attendance history →</span></a>
        </section>

        <div class="pm-content-grid">
            <section class="pm-panel pm-tasks-panel">
                <div class="pm-panel-heading"><div><p class="pm-eyebrow">Your workload</p><h2>My tasks</h2></div><a href="{{ \App\Filament\Resources\TaskResource::getUrl('index', panel: 'staff') }}">View all <span>→</span></a></div>
                <div class="pm-task-list">
                    @forelse ($tasks as $task)
                        <div class="pm-task-row"><div class="pm-task-marker {{ $task->status === 'done' ? 'done' : '' }}"></div><div class="pm-task-main"><strong>{{ $task->title }}</strong><span>{{ $task->deadline ? 'Due ' . $task->deadline->format('M j, Y') : 'No deadline' }}</span></div><span class="pm-status-chip">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span></div>
                    @empty
                        <div class="pm-empty"><strong>No tasks yet</strong><span>Create your first task to start planning your work.</span></div>
                    @endforelse
                </div>
            </section>
            <section class="pm-panel pm-focus-panel">
                <p class="pm-eyebrow">Quick actions</p><h2>What do you want to do?</h2><p>Keep your workspace focused on the actions that matter today.</p>
                <div class="pm-quick-links"><a href="{{ \App\Filament\Resources\TaskResource::getUrl('create', panel: 'staff') }}">Create a task <span>→</span></a><a href="{{ \App\Filament\Resources\TaskResource::getUrl('index', panel: 'staff') }}">View my tasks <span>→</span></a><a href="{{ url('/staff/attendance') }}">Attendance history <span>→</span></a></div>
            </section>
        </div>
    </div>
    <script>
        function dashboardAttendance(){return{busy:false,clockedIn:false,error:null,clockInAt:null,elapsed:'—',branchName:@js($currentUser->primaryBranch?->name??'Primary branch'),get clockInTime(){return this.clockInAt?new Date(this.clockInAt).toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'}):'—'},async loadStatus(){try{const response=await fetch('{{ route('attendance.status') }}',{headers:{Accept:'application/json'}});if(!response.ok)return;const data=await response.json();this.clockedIn=!!data.clocked_in;this.clockInAt=data.attendance?.clock_in_at||null;this.branchName=data.attendance?.branch?.name||this.branchName;this.updateElapsed()}catch(e){}},updateElapsed(){if(!this.clockedIn||!this.clockInAt){this.elapsed='—';return}const seconds=Math.max(0,Math.floor((Date.now()-new Date(this.clockInAt).getTime())/1000));const h=Math.floor(seconds/3600),m=Math.floor(seconds%3600/60);this.elapsed=`${String(h).padStart(2,'0')}h ${String(m).padStart(2,'0')}m`;setTimeout(()=>this.updateElapsed(),60000)},submit(action){this.busy=true;this.error=null;if(!navigator.geolocation){this.error='Your browser does not support location services.';this.busy=false;return}navigator.geolocation.getCurrentPosition(position=>this.send(action,position),error=>{this.error=error.code===1?'Location permission was denied.':'Unable to determine your location. Please try again.';this.busy=false},{enableHighAccuracy:true,timeout:15000,maximumAge:0})},async send(action,position){try{const response=await fetch(`/attendance/${action}`,{method:'POST',headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||''},body:JSON.stringify({latitude:position.coords.latitude,longitude:position.coords.longitude,accuracy:position.coords.accuracy})});const data=await response.json().catch(()=>({}));if(!response.ok){this.error=data.message||'Attendance action failed.'}else{await this.loadStatus()}}catch(e){this.error='Unable to complete the attendance action. Please try again.'}finally{this.busy=false}}}}
    </script>
</x-filament-panels::page>

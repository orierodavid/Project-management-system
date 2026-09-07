<x-filament-panels::page>
    <div class="pm-dashboard pm-staff-dashboard">
        <header class="pm-dashboard-header">
            <div class="pm-dashboard-heading">
                <p class="pm-eyebrow">My workspace</p>
                <h1>My Tasks</h1>
                <p>Tasks assigned to you by your administrator.</p>
            </div>
            <div class="pm-header-date"><span class="pm-date-dot"></span>{{ now()->format('l, F j') }}</div>
        </header>

        <section class="pm-kpi-grid">
            <div class="pm-kpi"><span class="pm-kpi-label">Open tasks</span><strong>{{ $openCount }}</strong><span class="pm-kpi-note">Tasks requiring your attention</span></div>
            <div class="pm-kpi"><span class="pm-kpi-label">Due soon</span><strong>{{ $dueSoonCount }}</strong><span class="pm-kpi-note">Due within the next 48 hours</span></div>
            <div class="pm-kpi"><span class="pm-kpi-label">Completed</span><strong>{{ $completedCount }}</strong><span class="pm-kpi-note">Tasks you have completed</span></div>
        </section>

        <section class="pm-panel pm-tasks-panel">
            <div class="pm-panel-heading">
                <div><p class="pm-eyebrow">Assigned work</p><h2>My task list</h2></div>
            </div>
            <div class="pm-task-list">
                @forelse ($tasks as $task)
                    <article class="pm-task-row">
                        <div class="pm-task-marker {{ $task->status === 'done' ? 'done' : '' }}"></div>
                        <div class="pm-task-main">
                            <strong>{{ $task->title }}</strong>
                            <span>{{ $task->department?->name ?? 'No department' }} · {{ $task->branch?->name ?? 'No branch' }}</span>
                        </div>
                        <span class="pm-status-chip">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span>
                        <span class="pm-task-main"><span>{{ $task->deadline ? 'Due ' . $task->deadline->format('M j, Y · g:i A') : 'No deadline' }}</span></span>
                    </article>
                @empty
                    <div class="pm-empty"><strong>No tasks assigned</strong><span>Your administrator has not assigned any tasks to you yet.</span></div>
                @endforelse
            </div>
        </section>
    </div>
</x-filament-panels::page>

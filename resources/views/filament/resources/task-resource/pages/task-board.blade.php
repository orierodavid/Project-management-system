<x-filament-panels::page>
    <div class="pm-task-board-v2">
        <header class="pm-board-head-v2">
            <div>
                <p class="pm-eyebrow">WORKSPACE / TASKS</p>
                <h1>Task board</h1>
                <p>Track delivery across every stage of the workflow.</p>
            </div>
            <div class="pm-board-actions-v2">
                <a class="pm-board-button-v2 pm-board-button-secondary-v2" href="{{ \App\Filament\Resources\TaskResource::getUrl('index') }}">List view</a>
                @if (auth()->user()?->can('manage-tasks'))
                    <a class="pm-board-button-v2 pm-board-button-primary-v2" href="{{ \App\Filament\Resources\TaskResource::getUrl('create') }}"><span>+</span> New task</a>
                @endif
            </div>
        </header>

        <div class="pm-board-summary-v2">
            <span><strong>{{ $tasks->flatten()->count() }}</strong> total tasks</span>
            <span><i></i> Drag-and-drop ready workspace</span>
        </div>

        <div class="pm-kanban-v2">
            @foreach ($columns as $status => $column)
                @php($columnTasks = $tasks->get($status, collect()))
                <section class="pm-kanban-column-v2">
                    <header class="pm-kanban-column-head-v2">
                        <div class="pm-kanban-title-row-v2"><span class="pm-status-dot pm-status-{{ $status }}"></span><h2>{{ $column['label'] }}</h2><span class="pm-count-v2">{{ $columnTasks->count() }}</span></div>
                        <p>{{ $column['description'] }}</p>
                    </header>
                    <div class="pm-kanban-stack-v2">
                        @forelse ($columnTasks as $task)
                            <a href="{{ \App\Filament\Resources\TaskResource::getUrl('edit', ['record' => $task]) }}" class="pm-task-card-v2">
                                <div class="pm-task-card-top-v2"><span class="pm-priority pm-priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>@if ($task->is_overdue)<span class="pm-overdue-v2">Overdue</span>@endif</div>
                                <h3>{{ $task->title }}</h3>
                                <div class="pm-task-card-meta-v2">@if ($task->department)<span>{{ $task->department->name }}</span>@endif @if ($task->deadline)<span>Due {{ $task->deadline->format('M j') }}</span>@endif</div>
                                <div class="pm-task-card-footer-v2"><span class="pm-avatar-v2">{{ strtoupper(substr($task->assignee?->name ?? 'U', 0, 1)) }}</span><span class="pm-assignee-v2">{{ $task->assignee?->name ?? 'Unassigned' }}</span><span class="pm-card-arrow-v2">↗</span></div>
                            </a>
                        @empty
                            <div class="pm-empty-column-v2"><span>+</span><p>No tasks here yet</p><small>Tasks will appear in this stage.</small></div>
                        @endforelse
                    </div>
                </section>
            @endforeach
        </div>
    </div>

    <style>
        .pm-task-board-v2{width:100%;max-width:1600px;margin:0 auto;padding:0 0 28px}.pm-board-head-v2{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:14px}.pm-board-head-v2 h1{margin:4px 0 5px;color:var(--pm-ink);font-size:30px;line-height:1.15;font-weight:760;letter-spacing:-.04em}.pm-board-head-v2 p:not(.pm-eyebrow){margin:0;color:var(--pm-muted);font-size:14px}.pm-board-actions-v2{display:flex;align-items:center;gap:9px}.pm-board-button-v2{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:38px;padding:0 14px;border-radius:8px;text-decoration:none;font-size:12px;font-weight:750;border:1px solid var(--pm-border-strong);white-space:nowrap}.pm-board-button-secondary-v2{background:#fff;color:#344054}.pm-board-button-primary-v2{background:var(--pm-accent);border-color:var(--pm-accent);color:#fff}.pm-board-button-primary-v2:hover{background:var(--pm-accent-dark)}.pm-board-summary-v2{display:flex;align-items:center;gap:18px;margin-bottom:14px;color:#667085;font-size:11px}.pm-board-summary-v2 strong{color:#344054}.pm-board-summary-v2 i{display:inline-block;width:6px;height:6px;margin-right:5px;border-radius:50%;background:#22c55e}.pm-kanban-v2{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;align-items:start}.pm-kanban-column-v2{min-width:0;background:#f0f2f5;border:1px solid #e1e5eb;border-radius:10px;padding:10px}.pm-kanban-column-head-v2{padding:5px 5px 12px}.pm-kanban-title-row-v2{display:flex;align-items:center;gap:7px}.pm-kanban-title-row-v2 h2{margin:0;color:#344054;font-size:13px;font-weight:750}.pm-kanban-column-head-v2 p{margin:5px 0 0 17px;color:#98a2b3;font-size:10px;line-height:1.4}.pm-count-v2{display:inline-grid;place-items:center;min-width:22px;height:21px;padding:0 6px;border-radius:6px;background:#fff;border:1px solid #dfe3e8;color:#667085;font-size:10px;font-weight:750}.pm-kanban-stack-v2{display:flex;flex-direction:column;gap:9px}.pm-task-card-v2{display:block;padding:14px;background:#fff;border:1px solid #e1e5eb;border-radius:9px;color:inherit;text-decoration:none;box-shadow:0 1px 2px rgba(16,24,40,.04);transition:border-color .15s,box-shadow .15s,transform .15s}.pm-task-card-v2:hover{border-color:#c4cad3;box-shadow:0 5px 15px rgba(16,24,40,.07);transform:translateY(-1px)}.pm-task-card-top-v2{display:flex;align-items:center;justify-content:space-between;gap:7px;min-height:21px}.pm-task-card-v2 h3{margin:11px 0 9px;color:#101828;font-size:13px;line-height:1.45;font-weight:700;letter-spacing:-.01em;overflow-wrap:anywhere}.pm-overdue-v2{padding:4px 6px;border-radius:5px;background:#fef3f2;color:#b42318;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}.pm-task-card-meta-v2{display:flex;flex-wrap:wrap;gap:6px 10px;color:#667085;font-size:10px}.pm-task-card-meta-v2 span+span{position:relative;padding-left:10px}.pm-task-card-meta-v2 span+span:before{content:'';position:absolute;left:0;top:4px;width:3px;height:3px;border-radius:50%;background:#98a2b3}.pm-task-card-footer-v2{display:flex;align-items:center;gap:7px;margin-top:13px;padding-top:11px;border-top:1px solid #f0f2f5}.pm-avatar-v2{display:grid;place-items:center;width:24px;height:24px;border-radius:50%;background:#eef2ff;color:#4338ca;font-size:9px;font-weight:800;flex:0 0 auto}.pm-assignee-v2{min-width:0;overflow:hidden;color:#475467;font-size:10px;font-weight:650;text-overflow:ellipsis;white-space:nowrap}.pm-card-arrow-v2{margin-left:auto;color:#98a2b3;font-size:15px}.pm-empty-column-v2{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:145px;padding:20px 10px;border:1px dashed #d5dae1;border-radius:8px;text-align:center}.pm-empty-column-v2 span{display:grid;place-items:center;width:25px;height:25px;margin-bottom:7px;border:1px solid #d5dae1;border-radius:6px;color:#98a2b3}.pm-empty-column-v2 p{margin:0;color:#667085;font-size:11px;font-weight:650}.pm-empty-column-v2 small{margin-top:4px;color:#98a2b3;font-size:9px}
        @media(max-width:1200px){.pm-kanban-v2{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:760px){.pm-task-board-v2{padding-bottom:20px}.pm-board-head-v2{align-items:flex-start;flex-direction:column;gap:15px}.pm-board-head-v2 h1{font-size:25px}.pm-board-actions-v2{width:100%}.pm-board-button-v2{flex:1}.pm-board-summary-v2{margin-bottom:12px}.pm-kanban-v2{grid-template-columns:1fr;gap:10px}.pm-kanban-column-v2{padding:9px}.pm-kanban-column-head-v2{padding-bottom:10px}.pm-kanban-stack-v2{gap:8px}.pm-task-card-v2{padding:13px}.pm-task-card-v2 h3{font-size:13px}.pm-empty-column-v2{min-height:110px}}
    </style>
</x-filament-panels::page>

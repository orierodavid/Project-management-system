<x-filament-panels::page>
    <div class="pm-task-board-v3">
        <header class="pm-board-header-v3">
            <div>
                <div class="pm-eyebrow">WORKSPACE / TASKS</div>
                <h1>Task board</h1>
                <p>A focused view of work moving through your delivery pipeline.</p>
            </div>
            <div class="pm-board-actions-v3">
                <a href="{{ \App\Filament\Resources\TaskResource::getUrl('index') }}" class="pm-btn-v3 pm-btn-secondary-v3">List view</a>
                @if (auth()->user()?->can('manage-tasks'))
                    <a href="{{ \App\Filament\Resources\TaskResource::getUrl('create') }}" class="pm-btn-v3 pm-btn-primary-v3"><span>+</span> New task</a>
                @endif
            </div>
        </header>

        <div class="pm-board-toolbar-v3">
            <div><strong>{{ $tasks->flatten()->count() }}</strong> tasks across {{ count($columns) }} stages</div>
            <div class="pm-board-live-v3"><span></span> Live workspace</div>
        </div>

        <div class="pm-kanban-v3">
            @foreach ($columns as $status => $column)
                @php($columnTasks = $tasks->get($status, collect()))
                <section class="pm-column-v3">
                    <header class="pm-column-header-v3">
                        <div class="pm-column-title-v3">
                            <span class="pm-status-v3 pm-status-{{ $status }}"></span>
                            <h2>{{ $column['label'] }}</h2>
                            <span class="pm-count-v3">{{ $columnTasks->count() }}</span>
                        </div>
                        <p>{{ $column['description'] }}</p>
                    </header>

                    <div class="pm-column-stack-v3">
                        @forelse ($columnTasks as $task)
                            <a href="{{ \App\Filament\Resources\TaskResource::getUrl('edit', ['record' => $task]) }}" class="pm-task-v3">
                                <div class="pm-task-top-v3">
                                    <span class="pm-priority pm-priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                    @if ($task->is_overdue)<span class="pm-overdue-v3">Overdue</span>@endif
                                </div>
                                <h3>{{ $task->title }}</h3>
                                <div class="pm-task-details-v3">
                                    @if ($task->department)<span>{{ $task->department->name }}</span>@endif
                                    @if ($task->deadline)<span>Due {{ $task->deadline->format('M j') }}</span>@endif
                                </div>
                                <footer class="pm-task-footer-v3">
                                    <span class="pm-avatar-v3">{{ strtoupper(substr($task->assignee?->name ?? 'U', 0, 1)) }}</span>
                                    <span class="pm-assignee-v3">{{ $task->assignee?->name ?? 'Unassigned' }}</span>
                                    <span class="pm-arrow-v3">→</span>
                                </footer>
                            </a>
                        @empty
                            <div class="pm-empty-v3">
                                <span>+</span>
                                <strong>No tasks</strong>
                                <small>This stage is clear.</small>
                            </div>
                        @endforelse
                    </div>
                </section>
            @endforeach
        </div>
    </div>

    <style>
        .pm-task-board-v3{max-width:1680px;margin:0 auto;padding-bottom:32px}.pm-board-header-v3{display:flex;align-items:flex-end;justify-content:space-between;gap:28px;margin-bottom:20px}.pm-board-header-v3 h1{margin:5px 0 6px;color:var(--pm-ink);font-size:30px;line-height:1.12;font-weight:760;letter-spacing:-.045em}.pm-board-header-v3 p{margin:0;color:var(--pm-muted);font-size:14px}.pm-board-actions-v3{display:flex;gap:8px}.pm-btn-v3{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:40px;padding:0 15px;border-radius:8px;border:1px solid var(--pm-border-strong);font-size:12px;font-weight:750;text-decoration:none}.pm-btn-secondary-v3{background:#fff;color:#344054}.pm-btn-primary-v3{background:var(--pm-accent);border-color:var(--pm-accent);color:#fff}.pm-btn-primary-v3:hover{background:var(--pm-accent-dark)}.pm-board-toolbar-v3{display:flex;align-items:center;justify-content:space-between;padding:12px 2px;margin-bottom:10px;color:#667085;font-size:11px}.pm-board-toolbar-v3 strong{color:#344054}.pm-board-live-v3{display:flex;align-items:center;gap:7px;font-weight:650}.pm-board-live-v3 span{width:6px;height:6px;border-radius:50%;background:#12b76a}.pm-kanban-v3{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;align-items:start}.pm-column-v3{min-width:0;padding:9px;background:#f5f6f8;border:1px solid #e4e7ec;border-radius:10px}.pm-column-header-v3{padding:5px 6px 12px}.pm-column-title-v3{display:flex;align-items:center;gap:8px}.pm-column-title-v3 h2{margin:0;color:#344054;font-size:13px;font-weight:750}.pm-count-v3{display:inline-flex;align-items:center;justify-content:center;min-width:22px;height:21px;padding:0 6px;border:1px solid #e1e5eb;border-radius:6px;background:#fff;color:#667085;font-size:10px;font-weight:750}.pm-column-header-v3 p{margin:5px 0 0 16px;color:#98a2b3;font-size:10px;line-height:1.4}.pm-status-v3{width:7px;height:7px;border-radius:50%;background:#98a2b3}.pm-status-todo{background:#98a2b3}.pm-status-in_progress{background:#2e90fa}.pm-status-review{background:#f79009}.pm-status-done{background:#12b76a}.pm-column-stack-v3{display:flex;flex-direction:column;gap:8px}.pm-task-v3{display:block;padding:14px;background:#fff;border:1px solid #e1e5eb;border-radius:8px;color:inherit;text-decoration:none;box-shadow:0 1px 2px rgba(16,24,40,.03);transition:transform .15s ease,box-shadow .15s ease,border-color .15s ease}.pm-task-v3:hover{transform:translateY(-1px);border-color:#cbd0d8;box-shadow:0 7px 18px rgba(16,24,40,.07)}.pm-task-top-v3{display:flex;align-items:center;justify-content:space-between;min-height:20px;gap:8px}.pm-task-v3 h3{margin:10px 0 9px;color:#101828;font-size:13px;line-height:1.45;font-weight:700;letter-spacing:-.01em}.pm-overdue-v3{padding:3px 6px;border-radius:5px;background:#fef3f2;color:#b42318;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}.pm-task-details-v3{display:flex;flex-wrap:wrap;gap:6px 12px;color:#667085;font-size:10px}.pm-task-details-v3 span+span{position:relative;padding-left:11px}.pm-task-details-v3 span+span:before{content:'';position:absolute;left:0;top:4px;width:3px;height:3px;border-radius:50%;background:#98a2b3}.pm-task-footer-v3{display:flex;align-items:center;gap:7px;margin-top:12px;padding-top:10px;border-top:1px solid #f0f2f5}.pm-avatar-v3{display:grid;place-items:center;width:24px;height:24px;border-radius:50%;background:#eef2ff;color:#4338ca;font-size:9px;font-weight:800}.pm-assignee-v3{min-width:0;overflow:hidden;color:#475467;font-size:10px;font-weight:650;text-overflow:ellipsis;white-space:nowrap}.pm-arrow-v3{margin-left:auto;color:#98a2b3;font-size:14px}.pm-empty-v3{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:130px;border:1px dashed #d5dae1;border-radius:8px;text-align:center}.pm-empty-v3 span{display:grid;place-items:center;width:25px;height:25px;margin-bottom:7px;border:1px solid #d5dae1;border-radius:6px;color:#98a2b3}.pm-empty-v3 strong{color:#667085;font-size:11px}.pm-empty-v3 small{margin-top:3px;color:#98a2b3;font-size:9px}@media(max-width:1200px){.pm-kanban-v3{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:760px){.pm-board-header-v3{align-items:flex-start;flex-direction:column;gap:15px}.pm-board-header-v3 h1{font-size:25px}.pm-board-actions-v3{width:100%}.pm-btn-v3{flex:1}.pm-board-toolbar-v3{padding-top:2px}.pm-kanban-v3{grid-template-columns:1fr}.pm-column-v3{padding:8px}}
    </style>
</x-filament-panels::page>

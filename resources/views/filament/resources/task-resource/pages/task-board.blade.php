<x-filament-panels::page>
    <div class="pm-task-board">
        <div class="pm-board-head">
            <div>
                <p class="pm-eyebrow">WORKSPACE</p>
                <h1>Task board</h1>
                <p>Track delivery across every stage of the workflow.</p>
            </div>
            <div class="pm-board-actions">
                <a class="pm-board-button pm-board-button-secondary" href="{{ \App\Filament\Resources\TaskResource::getUrl('index') }}">List view</a>
                @if (auth()->user()?->can('manage-tasks'))
                    <a class="pm-board-button pm-board-button-primary" href="{{ \App\Filament\Resources\TaskResource::getUrl('create') }}">+ New task</a>
                @endif
            </div>
        </div>

        <div class="pm-kanban">
            @foreach ($columns as $status => $column)
                @php($columnTasks = $tasks->get($status, collect()))
                <section class="pm-kanban-column">
                    <header class="pm-kanban-column-head">
                        <div>
                            <div class="pm-kanban-title-row">
                                <span class="pm-status-dot pm-status-{{ $status }}"></span>
                                <h2>{{ $column['label'] }}</h2>
                                <span class="pm-count">{{ $columnTasks->count() }}</span>
                            </div>
                            <p>{{ $column['description'] }}</p>
                        </div>
                    </header>

                    <div class="pm-kanban-stack">
                        @forelse ($columnTasks as $task)
                            <a href="{{ \App\Filament\Resources\TaskResource::getUrl('edit', ['record' => $task]) }}" class="pm-task-card">
                                <div class="pm-task-card-top">
                                    <span class="pm-priority pm-priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                    @if ($task->is_overdue)
                                        <span class="pm-overdue">Overdue</span>
                                    @endif
                                </div>
                                <h3>{{ $task->title }}</h3>
                                <div class="pm-task-card-meta">
                                    @if ($task->department)
                                        <span>{{ $task->department->name }}</span>
                                    @endif
                                    @if ($task->deadline)
                                        <span>Due {{ $task->deadline->format('M j') }}</span>
                                    @endif
                                </div>
                                <div class="pm-task-card-footer">
                                    <span class="pm-avatar">{{ strtoupper(substr($task->assignee?->name ?? 'U', 0, 1)) }}</span>
                                    <span>{{ $task->assignee?->name ?? 'Unassigned' }}</span>
                                    <span class="pm-card-arrow">↗</span>
                                </div>
                            </a>
                        @empty
                            <div class="pm-empty-column">
                                <span>—</span>
                                <p>No tasks here yet</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>

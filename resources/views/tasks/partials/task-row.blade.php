@php
    $isOverdue = $task->due_date && $task->due_date->isPast() && $task->status !== 'Done';
    $daysOver  = $isOverdue ? max(1, (int) $task->due_date->diffInDays(now())) : 0;

    $statusMeta = match($task->status) {
        'Todo'        => ['label' => 'To Do',       'badge' => 'tf-badge--todo',     'icon-bg' => 'bg-todo-soft',     'icon' => 'bi-circle'],
        'In Progress' => ['label' => 'In Progress',  'badge' => 'tf-badge--progress', 'icon-bg' => 'bg-progress-soft', 'icon' => 'bi-hourglass-split'],
        default       => ['label' => 'Done',         'badge' => 'tf-badge--done',     'icon-bg' => 'bg-done-soft',     'icon' => 'bi-check2'],
    };

    $priority  = $task->priority ?? 'Medium';
    $prioClass = match(strtolower($priority)) {
        'high'   => 'prio-high',
        'medium' => 'prio-medium',
        'low'    => 'prio-low',
        default  => 'prio-medium',
    };

    // Adjust these two lines if your column names are different
    $assigneeId = $task->assigned_to ?? $task->user_id ?? $task->assignee_id ?? null;
@endphp

<div class="task-row">
    {{-- Column 1: Task --}}
    <div class="task-row__main">
        <div class="task-type-icon {{ $statusMeta['icon-bg'] }}">
            <i class="bi {{ $statusMeta['icon'] }}"></i>
        </div>
        <div class="task-row__text">
            <div class="task-row__title" title="{{ $task->title }}">
                {{ $task->title }}
            </div>
            @if($task->description)
                <div class="task-row__desc">
                    {{ \Illuminate\Support\Str::limit($task->description, 60) }}
                </div>
            @endif
        </div>
    </div>

    {{-- Column 2: Status --}}
    <div class="task-row__status">
        <span class="tf-badge {{ $statusMeta['badge'] }}">{{ $statusMeta['label'] }}</span>
    </div>

    {{-- Column 3: Assignee --}}
    <div class="task-row__assignee">
        @php $assignee = $task->assignee ?? $task->user ?? $task->project->members->first(); @endphp
        @if($assignee)
            <div class="avatar-circle">
                {{ strtoupper(substr($assignee->name, 0, 1)) }}
            </div>
            <span title="{{ $assignee->name }}">{{ $assignee->name }}</span>
        @else
            <span class="text-muted">Unassigned</span>
        @endif
    </div>

    {{-- Column 4: Due Date --}}
    <div class="task-row__due">
        <div class="due-date {{ $isOverdue ? 'is-overdue' : '' }}">
            <i class="bi bi-calendar3"></i>
            {{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}
        </div>
        @if($isOverdue)
            <div class="overdue-label">
                Overdue by {{ $daysOver }} day{{ $daysOver > 1 ? 's' : '' }}
            </div>
        @endif
    </div>

    {{-- Column 5: Priority --}}
    <div class="task-row__priority">
        <span class="priority-badge {{ $prioClass }}">{{ $priority }}</span>
    </div>

    {{-- Column 6: Actions --}}
    <div class="task-row__actions">
        <div class="dropdown">
            <button class="btn-icon-more"
                    type="button"
                    data-bs-toggle="dropdown"
                    data-bs-display="static"
                    aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item" href="{{ route('projects.tasks.show', [$task->project, $task]) }}">
                        <i class="bi bi-eye me-2"></i> View
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('projects.tasks.edit', [$task->project, $task]) }}">
                        <i class="bi bi-pencil me-2"></i> Edit
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                {{-- Move to Todo --}}
                <li>
                    <form action="{{ route('projects.tasks.update', [$task->project, $task]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                        <input type="hidden" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                        <input type="hidden" name="priority" value="{{ $task->priority }}">
                        <input type="hidden" name="assigned_to" value="{{ $assigneeId }}"> {{-- change name if needed --}}
                        <input type="hidden" name="status" value="Todo">
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-circle me-2"></i> Move to Todo
                        </button>
                    </form>
                </li>

                {{-- Move to Doing --}}
                <li>
                    <form action="{{ route('projects.tasks.update', [$task->project, $task]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                        <input type="hidden" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                        <input type="hidden" name="priority" value="{{ $task->priority }}">
                        <input type="hidden" name="assigned_to" value="{{ $assigneeId }}"> {{-- change name if needed --}}
                        <input type="hidden" name="status" value="In Progress">
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-arrow-repeat me-2"></i> Move to Doing
                        </button>
                    </form>
                </li>

                {{-- Move to Done --}}
                <li>
                    <form action="{{ route('projects.tasks.update', [$task->project, $task]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                        <input type="hidden" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                        <input type="hidden" name="priority" value="{{ $task->priority }}">
                        <input type="hidden" name="assigned_to" value="{{ $assigneeId }}"> {{-- change name if needed --}}
                        <input type="hidden" name="status" value="Done">
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-check-circle me-2"></i> Move to Done
                        </button>
                    </form>
                </li>

                {{-- Move to Overdue (force past due date) --}}
                <li>
                    <form action="{{ route('projects.tasks.update', [$task->project, $task]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                        <input type="hidden" name="priority" value="{{ $task->priority }}">
                        <input type="hidden" name="assigned_to" value="{{ $assigneeId }}"> {{-- change name if needed --}}
                        <input type="hidden" name="status" value="In Progress">
                        <input type="hidden" name="due_date" value="{{ now()->subDay()->format('Y-m-d') }}">
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i> Move to Overdue
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
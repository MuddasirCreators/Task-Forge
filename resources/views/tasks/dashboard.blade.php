@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

{{-- Page Header --}}
<div class="tf-page-header">
    <div class="tf-page-header__left">
        <h1 class="tf-page-title">Tasks</h1>
        <p class="tf-page-subtitle">Organize, prioritize and track tasks across all your projects.</p>
    </div>
    <div class="tf-page-header__actions">
        <a href="{{ route('tasks.index', request()->query()) }}" class="tf-btn tf-btn--ghost">
            <i class="bi bi-download"></i>
            <span>Export</span>
        </a>
        <button type="button" class="tf-btn tf-btn--primary" onclick="showCreateTaskPopup()">
            <i class="bi bi-plus-lg"></i>
            <span>New Task</span>
        </button>
    </div>
</div>

@if($errors->any())
    <div class="tf-alert tf-alert--danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php $total = $totalTasks ?: 1; @endphp

{{-- Stats --}}
<div class="tf-stats">
    <div class="tf-stat tf-stat--total">
        <div class="tf-stat__icon"><i class="bi bi-kanban"></i></div>
        <div class="tf-stat__body">
            <span class="tf-stat__label">Total Tasks</span>
            <span class="tf-stat__value">{{ $totalTasks }}</span>
            <span class="tf-stat__meta">100% of all tasks</span>
        </div>
    </div>

    <div class="tf-stat tf-stat--todo">
        <div class="tf-stat__icon"><i class="bi bi-circle"></i></div>
        <div class="tf-stat__body">
            <span class="tf-stat__label">To Do</span>
            <span class="tf-stat__value">{{ $todoTasks }}</span>
            <span class="tf-stat__meta">{{ number_format(($todoTasks / $total) * 100, 1) }}%</span>
        </div>
    </div>

    <div class="tf-stat tf-stat--progress">
        <div class="tf-stat__icon"><i class="bi bi-play-circle"></i></div>
        <div class="tf-stat__body">
            <span class="tf-stat__label">Doing</span>
            <span class="tf-stat__value">{{ $progressTasks }}</span>
            <span class="tf-stat__meta">{{ number_format(($progressTasks / $total) * 100, 1) }}%</span>
        </div>
    </div>

    <div class="tf-stat tf-stat--done">
        <div class="tf-stat__icon"><i class="bi bi-check2-circle"></i></div>
        <div class="tf-stat__body">
            <span class="tf-stat__label">Done</span>
            <span class="tf-stat__value">{{ $doneTasks }}</span>
            <span class="tf-stat__meta">{{ number_format(($doneTasks / $total) * 100, 1) }}%</span>
        </div>
    </div>

    <div class="tf-stat tf-stat--overdue">
        <div class="tf-stat__icon"><i class="bi bi-alarm"></i></div>
        <div class="tf-stat__body">
            <span class="tf-stat__label">Overdue</span>
            <span class="tf-stat__value">{{ $overdueTasks }}</span>
            <span class="tf-stat__meta">{{ number_format(($overdueTasks / $total) * 100, 1) }}%</span>
        </div>
    </div>
</div>

{{-- Filters (only Search + Project) --}}
<div class="tf-filters">
    <form method="GET" action="{{ route('tasks.index') }}" class="tf-filters__form">
        <div class="tf-filters__field">
            <label>Search</label>
            <div class="tf-input-icon">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="tf-input" placeholder="Search tasks..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="tf-filters__field">
            <label>Project</label>
            <select name="project" class="tf-select">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ request('project') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="tf-filters__actions">
            <button type="submit" class="tf-btn tf-btn--primary tf-btn--icon" title="Apply filters">
                <i class="bi bi-funnel"></i>
            </button>
            <a href="{{ route('tasks.index') }}" class="tf-btn tf-btn--ghost tf-btn--icon" title="Reset">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

@php
    $isOverdue = fn($t) => $t->due_date && $t->due_date->isPast() && $t->status !== 'Done';

    $todoList     = $tasks->filter(fn($t) => $t->status === 'Todo' && !$isOverdue($t));
    $progressList = $tasks->filter(fn($t) => $t->status === 'In Progress' && !$isOverdue($t));
    $doneList     = $tasks->where('status', 'Done');
    $overdueList  = $tasks->filter($isOverdue);
@endphp

{{-- Task Groups --}}
<div class="tf-task-groups">

    {{-- TO DO --}}
    <div class="tf-group">
        <div class="tf-group__header">
            <div class="tf-group__title">
                <span class="tf-dot tf-dot--todo"></span>
                <span>TO DO</span>
                <span class="tf-count tf-count--todo">{{ $todoList->count() }}</span>
            </div>
            <button type="button" class="tf-group__toggle" onclick="toggleGroup(this)">
                <i class="bi bi-chevron-up"></i>
            </button>
        </div>
        <div class="tf-group__body">
            @forelse($todoList as $task)
                @include('tasks.partials.task-row', ['task' => $task])
            @empty
                <div class="tf-empty">No to-do tasks</div>
            @endforelse
        </div>
    </div>

    {{-- DOING --}}
    <div class="tf-group">
        <div class="tf-group__header">
            <div class="tf-group__title">
                <span class="tf-dot tf-dot--progress"></span>
                <span>DOING</span>
                <span class="tf-count tf-count--progress">{{ $progressList->count() }}</span>
            </div>
            <button type="button" class="tf-group__toggle" onclick="toggleGroup(this)">
                <i class="bi bi-chevron-up"></i>
            </button>
        </div>
        <div class="tf-group__body">
            @forelse($progressList as $task)
                @include('tasks.partials.task-row', ['task' => $task])
            @empty
                <div class="tf-empty">No doing tasks</div>
            @endforelse
        </div>
    </div>

    {{-- DONE --}}
    <div class="tf-group is-collapsed">
        <div class="tf-group__header">
            <div class="tf-group__title">
                <span class="tf-dot tf-dot--done"></span>
                <span>DONE</span>
                <span class="tf-count tf-count--done">{{ $doneList->count() }}</span>
            </div>
            <button type="button" class="tf-group__toggle" onclick="toggleGroup(this)">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="tf-group__body" style="display:none;">
            @forelse($doneList as $task)
                @include('tasks.partials.task-row', ['task' => $task])
            @empty
                <div class="tf-empty">No completed tasks</div>
            @endforelse
        </div>
    </div>

    {{-- OVERDUE --}}
    <div class="tf-group is-collapsed">
        <div class="tf-group__header">
            <div class="tf-group__title">
                <span class="tf-dot tf-dot--overdue"></span>
                <span>OVERDUE</span>
                <span class="tf-count tf-count--overdue">{{ $overdueList->count() }}</span>
            </div>
            <button type="button" class="tf-group__toggle" onclick="toggleGroup(this)">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="tf-group__body" style="display:none;">
            @forelse($overdueList as $task)
                @include('tasks.partials.task-row', ['task' => $task])
            @empty
                <div class="tf-empty">No overdue tasks</div>
            @endforelse
        </div>
    </div>
</div>

@if($tasks->hasPages())
    <div class="tf-pagination">
        {{ $tasks->links() }}
    </div>
@endif

@endsection

@push('scripts')
<script>
function toggleGroup(btn) {
    const group = btn.closest('.tf-group');
    const body  = group.querySelector('.tf-group__body');
    const icon  = btn.querySelector('i');

    group.classList.toggle('is-collapsed');

    if (group.classList.contains('is-collapsed')) {
        body.style.display = 'none';
        icon.className = 'bi bi-chevron-down';
    } else {
        body.style.display = 'block';
        icon.className = 'bi bi-chevron-up';
    }
}

function showCreateTaskPopup() {
    let options = '';
    @foreach($projects as $project)
        @if($project->members->count() > 0)
            options += `<option value="{{ $project->id }}">{{ $project->name }} ({{ $project->members->count() }} Member{{ $project->members->count() > 1 ? 's' : '' }})</option>`;
        @endif
    @endforeach

    if (options === '') {
        Swal.fire({
            icon: 'warning',
            title: 'No Project Available',
            text: 'Assign at least one member to a project before creating tasks.',
            confirmButtonColor: '#1a7a4a'
        });
        return;
    }

    Swal.fire({
        title: 'Create New Task',
        html: `
            <div class="text-start">
                <label class="form-label">Select Project</label>
                <select id="project_id" class="form-select">
                    <option value="">-- Select Project --</option>
                    ${options}
                </select>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Continue',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#1a7a4a',
        focusConfirm: false,
        preConfirm: () => {
            const project = document.getElementById('project_id').value;
            if (!project) {
                Swal.showValidationMessage('Please select a project.');
                return false;
            }
            return project;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url('/projects') }}/" + result.value + "/tasks/create";
        }
    });
}
</script>
@endpush
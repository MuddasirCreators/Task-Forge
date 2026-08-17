@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

{{-- Breadcrumb --}}
<nav class="tf-breadcrumb mb-3">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>›</span>
    <a href="{{ route('projects.index') }}">Projects</a>
    <span>›</span>
    <a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a>
    <span>›</span>
    <span class="active">Tasks</span>
</nav>

{{-- Page Header --}}
<div class="tf-page-header mb-4">
    <div>
        <h1 class="tf-page-title">Tasks</h1>
        <div class="tf-title-underline"></div>
        <p class="tf-page-subtitle mt-2">
            Organize, prioritize and track all tasks for <strong>{{ $project->name }}</strong>
        </p>
    </div>

    <div class="tf-page-actions">
        <a href="{{ route('projects.tasks.create', $project) }}" class="tf-btn tf-btn--primary">
            <i class="bi bi-plus-lg"></i> New Task
        </a>
    </div>
</div>

{{-- ===========================
     Statistics Cards
============================ --}}
<div class="tf-stats mb-4">
    <div class="tf-stat">
        <div class="tf-stat__icon bg-primary-soft">
            <i class="bi bi-clipboard-check"></i>
        </div>
        <div>
            <span class="tf-stat__label">Total Tasks</span>
            <h3 class="tf-stat__value">{{ $project->tasks()->count() }}</h3>
        </div>
    </div>

    <div class="tf-stat">
        <div class="tf-stat__icon bg-warning-soft">
            <i class="bi bi-circle"></i>
        </div>
        <div>
            <span class="tf-stat__label">To Do</span>
            <h3 class="tf-stat__value">{{ $project->tasks()->where('status','Todo')->count() }}</h3>
        </div>
    </div>

    <div class="tf-stat">
        <div class="tf-stat__icon bg-info-soft">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div>
            <span class="tf-stat__label">In Progress</span>
            <h3 class="tf-stat__value">{{ $project->tasks()->where('status','In Progress')->count() }}</h3>
        </div>
    </div>

    <div class="tf-stat">
        <div class="tf-stat__icon bg-success-soft">
            <i class="bi bi-check2-circle"></i>
        </div>
        <div>
            <span class="tf-stat__label">Completed</span>
            <h3 class="tf-stat__value">{{ $project->tasks()->where('status','Done')->count() }}</h3>
        </div>
    </div>
</div>

{{-- ===========================
        Task List
============================ --}}
<div class="tf-card">
    <div class="tf-card__body p-0">

        {{-- Table Header --}}
        <div class="task-list-header">
            <div class="task-col task-col--main">Task</div>
            <div class="task-col task-col--status">Status</div>
            <div class="task-col task-col--assignee">Assignee</div>
            <div class="task-col task-col--due">Due Date</div>
            <div class="task-col task-col--priority">Priority</div>
            <div class="task-col task-col--actions">Actions</div>
        </div>

        @forelse($tasks as $task)
            @include('tasks.partials.task-row', ['task' => $task])
        @empty
            <div class="tf-empty-state">
                <div class="tf-empty-icon">
                    <i class="bi bi-clipboard"></i>
                </div>
                <h4>No Tasks Found</h4>
                <p>There are no tasks available for this project.</p>
                <a href="{{ route('projects.tasks.create', $project) }}" class="tf-btn tf-btn--primary">
                    <i class="bi bi-plus-lg"></i> Create First Task
                </a>
            </div>
        @endforelse

    </div>
</div>

{{-- Pagination (10 per page) --}}
@if($tasks->hasPages())
    <div class="tf-pagination mt-4">
        {{ $tasks->withQueryString()->links() }}
    </div>
@endif

@endsection
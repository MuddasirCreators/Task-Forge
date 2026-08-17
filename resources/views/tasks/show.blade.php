@extends('layouts.app')

@section('title', 'Task Details')

@section('content')

{{-- Breadcrumb --}}
<nav class="tf-breadcrumb mb-3">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>›</span>
    <a href="{{ route('projects.index') }}">Projects</a>
    <span>›</span>
    <a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a>
    <span>›</span>
    <span class="active">Task Details</span>
</nav>

{{-- Page Header --}}
<div class="tf-page-header mb-4">
    <div>
        <h1 class="tf-page-title">Task Details</h1>
        <div class="tf-title-underline"></div>
        <p class="tf-page-subtitle mt-2">
            View task information for <strong>{{ $project->name }}</strong>
        </p>
    </div>

    <div class="tf-page-actions">
        <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="tf-btn tf-btn--primary">
            <i class="bi bi-pencil"></i> Edit Task
        </a>
        <a href="{{ route('projects.tasks.index', $project) }}" class="tf-btn tf-btn--ghost">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="tf-show-layout">

    {{-- ================= LEFT COLUMN ================= --}}
    <div class="tf-show-main">

        {{-- Main Info Card --}}
        <div class="tf-card">
            <div class="tf-card__header">
                <div class="tf-card__icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <h3 class="tf-card__title">{{ $task->title }}</h3>
            </div>

            <div class="tf-card__body">

                <div class="tf-detail-grid">
                    <div class="tf-detail-item">
                        <span class="tf-detail-label">Project</span>
                        <span class="tf-detail-value">
                            <a href="{{ route('projects.show', $project) }}" class="project-link">
                                {{ $project->name }}
                            </a>
                        </span>
                    </div>

                    <div class="tf-detail-item">
                        <span class="tf-detail-label">Status</span>
                        <span class="tf-detail-value">
                            @if($task->status === 'Todo')
                                <span class="tf-badge tf-badge--todo">To Do</span>
                            @elseif($task->status === 'In Progress')
                                <span class="tf-badge tf-badge--progress">In Progress</span>
                            @else
                                <span class="tf-badge tf-badge--done">Done</span>
                            @endif
                        </span>
                    </div>

                    <div class="tf-detail-item">
                        <span class="tf-detail-label">Priority</span>
                        <span class="tf-detail-value">
                            @php
                                $priority = $task->priority ?? 'Medium';
                                $prioClass = match(strtolower($priority)) {
                                    'high'   => 'prio-high',
                                    'medium' => 'prio-medium',
                                    'low'    => 'prio-low',
                                    default  => 'prio-medium',
                                };
                            @endphp
                            <span class="priority-badge {{ $prioClass }}">{{ $priority }}</span>
                        </span>
                    </div>

                    <div class="tf-detail-item">
                        <span class="tf-detail-label">Assignee</span>
                        <span class="tf-detail-value">
                            @if($task->assignee)
                                <div class="tf-assignee">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                    </div>
                                    {{ $task->assignee->name }}
                                </div>
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </span>
                    </div>

                    <div class="tf-detail-item">
                        <span class="tf-detail-label">Due Date</span>
                        <span class="tf-detail-value">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $task->due_date ? $task->due_date->format('d M Y') : '—' }}
                        </span>
                    </div>

                    <div class="tf-detail-item">
                        <span class="tf-detail-label">Created At</span>
                        <span class="tf-detail-value">
                            {{ $task->created_at->format('d M Y, h:i A') }}
                        </span>
                    </div>

                    <div class="tf-detail-item">
                        <span class="tf-detail-label">Last Updated</span>
                        <span class="tf-detail-value">
                            {{ $task->updated_at->format('d M Y, h:i A') }}
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                <div class="tf-description-block">
                    <h4 class="tf-section-title">Description</h4>
                    <div class="tf-description-content">
                        @if($task->description)
                            {!! nl2br(e($task->description)) !!}
                        @else
                            <span class="text-muted">No description available.</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
{{-- ================= TIME LOGS ================= --}}

<div class="tf-card mt-4">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-clock-history"></i>

        </div>

        <h3 class="tf-card__title">
            Time Logs
        </h3>

        <div style="margin-left:auto;">

            <a href="{{ route('tasks.time-logs.create', $task) }}"
               class="tf-btn tf-btn--primary tf-btn--sm">

                <i class="bi bi-plus-circle"></i>
                Add Time Log

            </a>

        </div>

    </div>



    <div class="tf-card__body">


        {{-- Total Time --}}

        <div class="mb-3">

            <strong>
                Total Logged Time:
            </strong>


            <span class="tf-badge tf-badge--progress">

                {{ $task->timeLogs->sum('minutes') }} Minutes

            </span>

        </div>




        @if($task->timeLogs->count())


        <div class="table-responsive">


            <table class="table">


                <thead>

                    <tr>

                        <th>
                            User
                        </th>

                        <th>
                            Minutes
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Note
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>



                <tbody>


                @foreach($task->timeLogs as $log)


                    <tr>


                        <td>

                            <div class="tf-assignee">

                                <div class="avatar-circle">

                                    {{ strtoupper(substr($log->user->name,0,1)) }}

                                </div>


                                {{ $log->user->name }}

                            </div>

                        </td>



                        <td>

                            <span class="tf-badge tf-badge--todo">

                                {{ $log->minutes }} mins

                            </span>

                        </td>



                        <td>

                            {{ $log->logged_at->format('d M Y') }}

                        </td>



                        <td>

                            {{ $log->note ?? '-' }}

                        </td>



                        <td>


                            <a href="{{ route('time-logs.edit',$log) }}"
                               class="btn btn-sm btn-warning">

                                <i class="bi bi-pencil"></i>

                            </a>



                            <form
                                action="{{ route('time-logs.destroy',$log) }}"
                                method="POST"
                                style="display:inline;">


                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this time log?')">


                                    <i class="bi bi-trash"></i>


                                </button>


                            </form>


                        </td>


                    </tr>


                @endforeach


                </tbody>


            </table>


        </div>


        @else


            <p class="text-muted">

                No time logs added yet.

            </p>


        @endif


    </div>

</div>
        {{-- Actions --}}
        <div class="tf-form-actions">
            <a href="{{ route('projects.tasks.index', $project) }}" class="tf-btn tf-btn--ghost">
                <i class="bi bi-arrow-left"></i> Back to Tasks
            </a>

            <div class="tf-form-actions__right">
                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="tf-btn tf-btn--primary">
                    <i class="bi bi-pencil"></i> Edit Task
                </a>

                <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this task?')">
                    @csrf
                    @method('DELETE')
                   
                </form>
            </div>
        </div>
    </div>

    {{-- ================= RIGHT SIDEBAR ================= --}}
    <div class="tf-show-sidebar">

        {{-- Quick Info --}}
        <div class="tf-card">
            <div class="tf-card__header">
                <div class="tf-card__icon">
                    <i class="bi bi-info-circle"></i>
                </div>
                <h3 class="tf-card__title">Quick Info</h3>
            </div>
            <div class="tf-card__body">
                <div class="tf-summary-item">
                    <i class="bi bi-folder"></i>
                    <div>
                        <span class="tf-summary-label">Project</span>
                        <span class="tf-summary-value">{{ $project->name }}</span>
                    </div>
                </div>
                <div class="tf-summary-item">
                    <i class="bi bi-person"></i>
                    <div>
                        <span class="tf-summary-label">Assignee</span>
                        <span class="tf-summary-value">
                            {{ $task->assignee?->name ?? 'Unassigned' }}
                        </span>
                    </div>
                </div>
                <div class="tf-summary-item">
                    <i class="bi bi-flag"></i>
                    <div>
                        <span class="tf-summary-label">Priority</span>
                        <span class="tf-summary-value">{{ $task->priority ?? 'Medium' }}</span>
                    </div>
                </div>
                <div class="tf-summary-item">
                    <i class="bi bi-circle"></i>
                    <div>
                        <span class="tf-summary-label">Status</span>
                        <span class="tf-summary-value">{{ $task->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Need Help --}}
        <div class="tf-card">
            <div class="tf-card__header">
                <div class="tf-card__icon tf-card__icon--help">
                    <i class="bi bi-question-circle"></i>
                </div>
                <h3 class="tf-card__title">Need Help?</h3>
            </div>
            <div class="tf-card__body">
                <p style="font-size:13.5px;color:var(--color-text-muted);margin-bottom:14px;">
                    Learn more about managing tasks.
                </p>
                <a href="#" class="tf-btn tf-btn--ghost tf-btn--sm">
                    View Help Center <i class="bi bi-box-arrow-up-right"></i>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

{{-- Breadcrumb --}}
<nav class="tf-breadcrumb mb-3">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>›</span>
    <a href="{{ route('projects.index') }}">Projects</a>
    <span>›</span>
    <a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a>
    <span>›</span>
    <span class="active">Edit Task</span>
</nav>

{{-- Page Header --}}
<div class="tf-page-header mb-4">
    <div>
        <h1 class="tf-page-title">Edit Task</h1>
        <div class="tf-title-underline"></div>
        <p class="tf-page-subtitle mt-2">
            Update task details for <strong>{{ $project->name }}</strong>
        </p>
    </div>
</div>

@if($errors->any())
    <div class="tf-alert tf-alert--danger mb-4">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('projects.tasks.update', [$project, $task]) }}"
      method="POST"
      id="editTaskForm">
    @csrf
    @method('PUT')

    <input type="hidden" name="project_id" value="{{ $project->id }}">

    <div class="tf-create-layout">

        {{-- ================= LEFT COLUMN ================= --}}
        <div class="tf-create-main">

            <div class="tf-card">
                <div class="tf-card__header">
                    <div class="tf-card__icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h3 class="tf-card__title">Task Details</h3>
                </div>

                <div class="tf-card__body">

                    {{-- Project + Task Title --}}
                    <div class="tf-form-row">
                        <div class="tf-form-group">
                            <label class="tf-label">
                                Project <span class="required">*</span>
                            </label>
                            <input type="text"
                                   class="tf-input"
                                   value="{{ $project->name }}"
                                   readonly>
                        </div>

                        <div class="tf-form-group">
                            <label class="tf-label">
                                Task Title <span class="required">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   class="tf-input @error('title') is-invalid @enderror"
                                   value="{{ old('title', $task->title) }}"
                                   placeholder="Enter a clear and concise title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="tf-form-group">
                        <label class="tf-label">Description</label>
                        <textarea name="description"
                                  rows="5"
                                  class="tf-textarea @error('description') is-invalid @enderror"
                                  placeholder="Describe the task, its purpose, and any important details...">{{ old('description', $task->description) }}</textarea>
                        <div class="tf-char-count">0 / 1000</div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status + Priority --}}
                    <div class="tf-form-row">
                        <div class="tf-form-group">
                            <label class="tf-label">
                                Status <span class="required">*</span>
                            </label>
                            <select name="status"
                                    class="tf-select @error('status') is-invalid @enderror"
                                    required>
                                <option value="Todo" {{ old('status', $task->status) == 'Todo' ? 'selected' : '' }}>
                                    To Do
                                </option>
                                <option value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'selected' : '' }}>
                                    In Progress
                                </option>
                                <option value="Done" {{ old('status', $task->status) == 'Done' ? 'selected' : '' }}>
                                    Done
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="tf-form-group">
                            <label class="tf-label">
                                Priority <span class="required">*</span>
                            </label>
                            <select name="priority"
                                    class="tf-select @error('priority') is-invalid @enderror"
                                    required>
                                <option value="High" {{ old('priority', $task->priority ?? 'Medium') == 'High' ? 'selected' : '' }}>
                                    High
                                </option>
                                <option value="Medium" {{ old('priority', $task->priority ?? 'Medium') == 'Medium' ? 'selected' : '' }}>
                                    Medium
                                </option>
                                <option value="Low" {{ old('priority', $task->priority ?? 'Medium') == 'Low' ? 'selected' : '' }}>
                                    Low
                                </option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Assignee + Due Date --}}
                    <div class="tf-form-row">
                        <div class="tf-form-group">
                            <label class="tf-label">
                                Assignee <span class="required">*</span>
                            </label>
                            <select name="assigned_to"
                                    class="tf-select @error('assigned_to') is-invalid @enderror"
                                    required>
                                <option value="">Select assignee</option>
                                @foreach($project->members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="tf-form-group">
                            <label class="tf-label">
                                Due Date <span class="required">*</span>
                            </label>
                            <div class="tf-input-icon">
                                <i class="bi bi-calendar3"></i>
                                <input type="date"
                                       name="due_date"
                                       class="tf-input @error('due_date') is-invalid @enderror"
                                       value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                                       required>
                            </div>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- Actions --}}
            <div class="tf-form-actions">
                <a href="{{ route('projects.tasks.index', $project) }}" class="tf-btn tf-btn--ghost">
                    <i class="bi bi-x-lg"></i> Cancel
                </a>

                <div class="tf-form-actions__right">
                    <button type="submit" class="tf-btn tf-btn--primary">
                        <i class="bi bi-check-lg"></i> Update Task
                    </button>
                </div>
            </div>
        </div>

        {{-- ================= RIGHT SIDEBAR ================= --}}
        <div class="tf-create-sidebar">

            {{-- Task Tips --}}
            <div class="tf-card">
                <div class="tf-card__header">
                    <div class="tf-card__icon tf-card__icon--tips">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h3 class="tf-card__title">Task Tips</h3>
                </div>
                <div class="tf-card__body">
                    <div class="tf-tip">
                        <div class="tf-tip__icon" style="background:#e0f2fe;color:#0284c7;">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div>
                            <strong>Be specific</strong>
                            <p>Clear titles and descriptions help everyone understand the task.</p>
                        </div>
                    </div>
                    <div class="tf-tip">
                        <div class="tf-tip__icon" style="background:#ffedd5;color:#ea580c;">
                            <i class="bi bi-flag"></i>
                        </div>
                        <div>
                            <strong>Set priority</strong>
                            <p>Choose the right priority to help your team focus.</p>
                        </div>
                    </div>
                    <div class="tf-tip">
                        <div class="tf-tip__icon" style="background:#e0e7ff;color:#4f46e5;">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <strong>Assign wisely</strong>
                            <p>Assign to the right team member for better results.</p>
                        </div>
                    </div>
                    <div class="tf-tip">
                        <div class="tf-tip__icon" style="background:#fce7f3;color:#db2777;">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <strong>Set due date</strong>
                            <p>Realistic deadlines keep projects on track.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Task Summary --}}
            <div class="tf-card">
                <div class="tf-card__header">
                    <div class="tf-card__icon">
                        <i class="bi bi-card-checklist"></i>
                    </div>
                    <h3 class="tf-card__title">Task Summary</h3>
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
                            <span class="tf-summary-value" id="summaryAssignee">
                                @php
                                    $currentAssignee = $project->members->firstWhere('id', old('assigned_to', $task->assigned_to));
                                @endphp
                                {{ $currentAssignee?->name ?? '—' }}
                            </span>
                        </div>
                    </div>
                    <div class="tf-summary-item">
                        <i class="bi bi-calendar3"></i>
                        <div>
                            <span class="tf-summary-label">Due Date</span>
                            <span class="tf-summary-value" id="summaryDueDate">
                                {{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}
                            </span>
                        </div>
                    </div>
                    <div class="tf-summary-item">
                        <i class="bi bi-flag"></i>
                        <div>
                            <span class="tf-summary-label">Priority</span>
                            <span class="tf-summary-value" id="summaryPriority">
                                {{ old('priority', $task->priority ?? 'Medium') }}
                            </span>
                        </div>
                    </div>
                    <div class="tf-summary-item">
                        <i class="bi bi-circle"></i>
                        <div>
                            <span class="tf-summary-label">Status</span>
                            <span class="tf-summary-value" id="summaryStatus">
                                {{ old('status', $task->status) }}
                            </span>
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
                        Learn more about creating and managing tasks.
                    </p>
                    <a href="#" class="tf-btn tf-btn--ghost tf-btn--sm">
                        View Help Center <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Character counter
    const textarea = document.querySelector('textarea[name="description"]');
    const counter  = document.querySelector('.tf-char-count');
    if (textarea && counter) {
        const update = () => counter.textContent = `${textarea.value.length} / 1000`;
        textarea.addEventListener('input', update);
        update();
    }

    // Live Summary
    const assigneeSelect = document.querySelector('select[name="assigned_to"]');
    const statusSelect   = document.querySelector('select[name="status"]');
    const prioritySelect = document.querySelector('select[name="priority"]');
    const dueDateInput   = document.querySelector('input[name="due_date"]');

    const summaryAssignee = document.getElementById('summaryAssignee');
    const summaryStatus   = document.getElementById('summaryStatus');
    const summaryPriority = document.getElementById('summaryPriority');
    const summaryDueDate  = document.getElementById('summaryDueDate');

    if (assigneeSelect) {
        assigneeSelect.addEventListener('change', function () {
            summaryAssignee.textContent = this.options[this.selectedIndex].text || '—';
        });
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', function () {
            summaryStatus.textContent = this.options[this.selectedIndex].text || '—';
        });
    }

    if (prioritySelect) {
        prioritySelect.addEventListener('change', function () {
            summaryPriority.textContent = this.options[this.selectedIndex].text || '—';
        });
    }

    if (dueDateInput) {
        dueDateInput.addEventListener('change', function () {
            if (this.value) {
                const d = new Date(this.value);
                summaryDueDate.textContent = d.toLocaleDateString('en-US', {
                    month: 'short', day: 'numeric', year: 'numeric'
                });
            } else {
                summaryDueDate.textContent = '—';
            }
        });
    }
});
</script>
@endpush
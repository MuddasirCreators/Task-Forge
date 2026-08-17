@extends('layouts.app')

@section('title', 'Team Member Details')


@section('content')


{{-- Breadcrumb --}}

<nav class="tf-breadcrumb mb-3">

    <a href="{{ route('dashboard') }}">
        Dashboard
    </a>

    <span>›</span>

    <a href="{{ route('team.index') }}">
        Team
    </a>

    <span>›</span>

    <span class="active">
        {{ $user->name }}
    </span>

</nav>



{{-- Page Header --}}

<div class="tf-page-header mb-4">

    <div>

        <h1 class="tf-page-title">
            Team Member Details
        </h1>

        <div class="tf-title-underline"></div>

        <p class="tf-page-subtitle mt-2">
            Complete account and work information for
            <strong>{{ $user->name }}</strong>.
        </p>

    </div>


    <div class="tf-page-actions">

        <a href="{{ route('team.edit', $user) }}"
           class="tf-btn tf-btn--primary">

            <i class="bi bi-pencil"></i>

            Edit User

        </a>


        <a href="{{ route('team.index') }}"
           class="tf-btn tf-btn--ghost">

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

    </div>

</div>



{{-- User Information --}}

<div class="tf-card mb-4">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-person"></i>

        </div>

        <h3 class="tf-card__title">
            User Information
        </h3>

    </div>


    <div class="tf-card__body">

        <div class="tf-detail-grid">


            {{-- Name --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Name
                </span>

                <span class="tf-detail-value">

                    <div class="tf-assignee">

                        <div class="avatar-circle">

                            {{ strtoupper(substr($user->name, 0, 1)) }}

                        </div>

                        {{ $user->name }}

                    </div>

                </span>

            </div>



            {{-- Email --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Email
                </span>

                <span class="tf-detail-value">

                    {{ $user->email }}

                </span>

            </div>



            {{-- Phone --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Phone
                </span>

                <span class="tf-detail-value">

                    {{ $user->phone ?? 'N/A' }}

                </span>

            </div>



            {{-- Role --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Role
                </span>

                <span class="tf-detail-value">

                    <span class="tf-badge">

                        {{ $user->role }}

                    </span>

                </span>

            </div>



            {{-- Account Status --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Account Status
                </span>

                <span class="tf-detail-value">

                    @if($user->is_active)

                        <span class="badge bg-success">
                            Active
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Inactive
                        </span>

                    @endif

                </span>

            </div>



            {{-- Login Status --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Login Status
                </span>

                <span class="tf-detail-value">

                    @if($user->is_logged_in)

                        <span class="badge bg-success">
                            Currently Logged In
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Logged Out
                        </span>

                    @endif

                </span>

            </div>



            {{-- Created At --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Account Created
                </span>

                <span class="tf-detail-value">

                    {{ $user->created_at->format('d M Y, h:i A') }}

                </span>

            </div>



            {{-- Updated At --}}

            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Last Updated
                </span>

                <span class="tf-detail-value">

                    {{ $user->updated_at->format('d M Y, h:i A') }}

                </span>

            </div>


        </div>

    </div>

</div>



{{-- Task Statistics --}}

<div class="tf-card mb-4">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-list-task"></i>

        </div>

        <h3 class="tf-card__title">
            Task Statistics
        </h3>

    </div>


    <div class="tf-card__body">


        <div class="row g-3">


            {{-- Total Tasks --}}

            <div class="col-md-6 col-lg-3">

                <div class="dashboard-card">

                    <h4>
                        Total Tasks
                    </h4>

                    <h2>
                        {{ $totalTasks }}
                    </h2>

                </div>

            </div>



            {{-- Todo --}}

            <div class="col-md-6 col-lg-3">

                <div class="dashboard-card">

                    <h4>
                        To Do
                    </h4>

                    <h2>
                        {{ $todoTasks }}
                    </h2>

                </div>

            </div>



            {{-- In Progress --}}

            <div class="col-md-6 col-lg-3">

                <div class="dashboard-card">

                    <h4>
                        In Progress
                    </h4>

                    <h2>
                        {{ $progressTasks }}
                    </h2>

                </div>

            </div>



            {{-- Completed --}}

            <div class="col-md-6 col-lg-3">

                <div class="dashboard-card">

                    <h4>
                        Completed
                    </h4>

                    <h2>
                        {{ $completedTasks }}
                    </h2>

                </div>

            </div>



            {{-- Overdue --}}

            <div class="col-md-6 col-lg-3">

                <div class="dashboard-card">

                    <h4>
                        Overdue
                    </h4>

                    <h2 class="text-danger">
                        {{ $overdueTasks }}
                    </h2>

                </div>

            </div>


        </div>

    </div>

</div>



{{-- Time Logs --}}

<div class="tf-card mb-4">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-clock-history"></i>

        </div>

        <h3 class="tf-card__title">
            Time Logs
        </h3>

    </div>


    <div class="tf-card__body">


        <div class="tf-detail-grid">


            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Total Logged Time
                </span>

                <span class="tf-detail-value">

                    <strong>

                        {{ $totalLogHours }}
                        hour(s)
                        {{ $remainingMinutes }}
                        minute(s)

                    </strong>

                </span>

            </div>



            <div class="tf-detail-item">

                <span class="tf-detail-label">
                    Total Minutes
                </span>

                <span class="tf-detail-value">

                    <span class="tf-badge">

                        {{ $totalLogMinutes }} mins

                    </span>

                </span>

            </div>


        </div>

    </div>

</div>



{{-- Assigned Tasks --}}

<div class="tf-card">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-clipboard-check"></i>

        </div>

        <h3 class="tf-card__title">
            Assigned Tasks
        </h3>

    </div>


    <div class="table-responsive">

        <table class="table tf-table">


            <thead>

                <tr>

                    <th>
                        Task
                    </th>

                    <th>
                        Project
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Due Date
                    </th>

                    <th>
                        Logged Time
                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($tasks as $task)

                    <tr>

                        <td>

                            <strong>
                                {{ $task->title }}
                            </strong>

                        </td>


                        <td>

                            {{ $task->project?->name ?? 'N/A' }}

                        </td>


                        <td>

                            @if($task->status === 'Todo')

                                <span class="tf-badge tf-badge--todo">
                                    To Do
                                </span>

                            @elseif($task->status === 'In Progress')

                                <span class="tf-badge tf-badge--progress">
                                    In Progress
                                </span>

                            @else

                                <span class="tf-badge tf-badge--done">
                                    Done
                                </span>

                            @endif

                        </td>


                        <td>

                            {{ $task->due_date
                                ? $task->due_date->format('d M Y')
                                : '—'
                            }}

                        </td>


                        <td>

                            <span class="tf-badge">

                                {{ $task->timeLogs->sum('minutes') }}
                                mins

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center">

                            No tasks assigned to this user.

                        </td>

                    </tr>

                @endforelse


            </tbody>

        </table>

    </div>

</div>



@endsection
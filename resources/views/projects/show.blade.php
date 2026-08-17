@extends('layouts.app')

@section('title', 'Project Details')

@section('content')

<div class="page-header">

    <div>

        <h1>Project Details</h1>

        <p>View complete project information</p>

    </div>

    <div>

        <a href="{{ route('projects.index') }}" class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

    </div>

</div>


<table class="details-table">

    <tr>

        <th width="220">Project Name</th>

        <td>{{ $project->name }}</td>

    </tr>

    <tr>

        <th>Client</th>

        <td>{{ $project->client->name }}</td>

    </tr>

    <tr>

        <th>Status</th>

        <td>

            @switch($project->status)

                @case('Pending')

                    <span class="badge badge-warning">

                        Pending

                    </span>

                    @break

                @case('In Progress')

                    <span class="badge badge-primary">

                        In Progress

                    </span>

                    @break

                @case('Completed')

                    <span class="badge badge-success">

                        Completed

                    </span>

                    @break

            @endswitch

        </td>

    </tr>

    <tr>

        <th>Archive Status</th>

        <td>

            @if($project->archived_at)

                <span class="badge badge-secondary">

                    Archived

                </span>

            @else

                <span class="badge badge-success">

                    Active

                </span>

            @endif

        </td>

    </tr>

    <tr>

        <th>Start Date</th>

        <td>

            {{ $project->start_date->format('d M Y') }}

        </td>

    </tr>

    <tr>

        <th>Due Date</th>

        <td>

            {{ $project->due_date->format('d M Y') }}

        </td>

    </tr>

    <tr>

        <th>Created By</th>

        <td>

            {{ $project->creator->name }}

        </td>

    </tr>

    <tr>

        <th>Total Tasks</th>

        <td>

            <span class="badge badge-info">

                {{ $project->tasks->count() }}

            </span>

        </td>

    </tr>

    <tr>

        <th>Created At</th>

        <td>

            {{ $project->created_at->format('d M Y h:i A') }}

        </td>

    </tr>

    <tr>

        <th>Last Updated</th>

        <td>

            {{ $project->updated_at->format('d M Y h:i A') }}

        </td>

    </tr>

</table>


<div class="form-actions">

    <a
        href="{{ route('projects.tasks.index', $project) }}"
        class="btn btn-info">

        <i class="bi bi-list-check"></i>

        Manage Tasks

    </a>

    @if(!$project->archived_at)

        <a href="{{ route('projects.edit', $project) }}"
           class="btn btn-warning">

            <i class="bi bi-pencil-square"></i>

            Edit Project

        </a>

    @else

        <button class="btn btn-warning" disabled>

            <i class="bi bi-lock-fill"></i>

            Archived (Read Only)

        </button>

    @endif

    <a href="{{ route('projects.index') }}"
       class="btn btn-secondary">

        <i class="bi bi-arrow-left-circle"></i>

        Back to Projects

    </a>

</div>

@endsection
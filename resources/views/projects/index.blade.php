@extends('layouts.app')

@section('title', 'Projects')

@section('content')

<div class="page-header">

    <div>

        <h1>Projects</h1>

        <p>Manage all projects of TaskForge</p>

    </div>

    <div>

        @if(!request()->boolean('archived'))

            <a href="{{ route('projects.create') }}" class="btn btn-primary">

                + Add Project

            </a>

        @endif

    </div>

</div>


{{-- Active / Archived Navigation --}}


{{-- Status Filter --}}
<div class="filter-card">

    <form action="{{ route('projects.index') }}" method="GET">

        @if(request()->boolean('archived'))

            <input type="hidden" name="archived" value="1">

        @endif

        <select name="status" class="form-control">

            <option value="">All Status</option>

            <option value="Pending"
                {{ request('status') == 'Pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="In Progress"
                {{ request('status') == 'In Progress' ? 'selected' : '' }}>
                In Progress
            </option>

            <option value="Completed"
                {{ request('status') == 'Completed' ? 'selected' : '' }}>
                Completed
            </option>

        </select>

        <button type="submit" class="btn btn-primary">

            Filter

        </button>

        @if(request()->boolean('archived'))

            <a href="{{ route('projects.index', ['archived' => 1]) }}"
               class="btn btn-secondary">

                Reset

            </a>

        @else

            <a href="{{ route('projects.index') }}"
               class="btn btn-secondary">

                Reset

            </a>

        @endif
<div class="mb-3">

    <a href="{{ route('projects.index') }}"
       class="btn {{ request()->boolean('archived') ? 'btn-secondary' : 'btn-primary' }}">

        Active Projects

    </a>

    <a href="{{ route('projects.index', ['archived' => 1]) }}"
       class="btn {{ request()->boolean('archived') ? 'btn-primary' : 'btn-secondary' }}">

        Archived Projects

    </a>

</div>

    </form>

</div>


<div class="table-card">

    <table class="table">

        <thead>

            <tr>

                <th>#</th>

                <th>Project Name</th>

                <th>Client</th>

                <th>Status</th>

                <th>Start Date</th>

                <th>Due Date</th>

                <th>Created By</th>

                <th width="300">Actions</th>

            </tr>

        </thead>

        <tbody>

            @forelse($projects as $project)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $project->name }}</td>

                    <td>{{ $project->client->name }}</td>

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

                    <td>{{ $project->start_date->format('d M Y') }}</td>

                    <td>{{ $project->due_date->format('d M Y') }}</td>

                    <td>{{ $project->creator->name }}</td>

                    <td>

                        {{-- View --}}
                        <a href="{{ route('projects.show', $project) }}"
                           class="btn btn-info btn-sm">

                            View

                        </a>

                        @if(request()->boolean('archived'))

                            {{-- Restore --}}

                            <form action="{{ route('projects.restore', $project) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf

                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-success btn-sm">

                                    Restore

                                </button>

                            </form>

                        @else

                            {{-- Edit --}}

                            <a href="{{ route('projects.edit', $project) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            {{-- Archive --}}

                            <form action="{{ route('projects.archive', $project) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf

                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    Archive

                                </button>

                            </form>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">

                        No Projects Found.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


<div class="pagination">

    {{ $projects->links() }}

</div>

@endsection
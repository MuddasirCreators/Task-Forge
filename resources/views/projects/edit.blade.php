@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')

<div class="page-header">

    <div>

        <h1>Edit Project</h1>

        <p>Update project information</p>

    </div>

    <div>

        <a href="{{ route('projects.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

<div class="form-card">

    <form action="{{ route('projects.update', $project) }}" method="POST">

        @csrf
        @method('PUT')

        {{-- Client --}}
        <div class="form-group">

            <label>

                Client <span class="text-danger">*</span>

            </label>

            <select
                name="client_id"
                class="form-control"
                required>

                @foreach($clients as $client)

                    <option
                        value="{{ $client->id }}"
                        {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>

                        {{ $client->name }}

                    </option>

                @endforeach

            </select>

            @error('client_id')

                <small class="text-danger">

                    {{ $message }}

                </small>

            @enderror

        </div>


        {{-- Project Name --}}
        <div class="form-group">

            <label>

                Project Name <span class="text-danger">*</span>

            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $project->name) }}">

            @error('name')

                <small class="text-danger">

                    {{ $message }}

                </small>

            @enderror

        </div>


        {{-- Status --}}
        <div class="form-group">

            <label>

                Status <span class="text-danger">*</span>

            </label>

            <select
                name="status"
                class="form-control">

                <option
                    value="Pending"
                    {{ old('status', $project->status) == 'Pending' ? 'selected' : '' }}>

                    Pending

                </option>

                <option
                    value="In Progress"
                    {{ old('status', $project->status) == 'In Progress' ? 'selected' : '' }}>

                    In Progress

                </option>

                <option
                    value="Completed"
                    {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>

                    Completed

                </option>

            </select>

            @error('status')

                <small class="text-danger">

                    {{ $message }}

                </small>

            @enderror

        </div>


        {{-- Dates --}}
        <div class="form-row">

            <div class="form-group">

                <label>

                    Start Date <span class="text-danger">*</span>

                </label>

                <input
                    type="date"
                    name="start_date"
                    class="form-control"
                    value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}">

                @error('start_date')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            <div class="form-group">

                <label>

                    Due Date <span class="text-danger">*</span>

                </label>

                <input
                    type="date"
                    name="due_date"
                    class="form-control"
                    value="{{ old('due_date', $project->due_date->format('Y-m-d')) }}">

                @error('due_date')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

        </div>


        {{-- Project Members --}}
        <div class="form-group">

            <label>

                Assign Members

            </label>

            <select
                id="member_ids"
                name="member_ids[]"
                multiple>

                @foreach($members as $member)

                    <option
                        value="{{ $member->id }}"
                        {{ in_array($member->id, old('member_ids', $project->members->pluck('id')->toArray())) ? 'selected' : '' }}>

                        {{ $member->name }} ({{ $member->email }})

                    </option>

                @endforeach

            </select>

            @error('member_ids')

                <small class="text-danger">

                    {{ $message }}

                </small>

            @enderror

            @error('member_ids.*')

                <small class="text-danger">

                    {{ $message }}

                </small>

            @enderror

        </div>


        {{-- Buttons --}}
        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary">

                Update Project

            </button>

            <a
                href="{{ route('projects.index') }}"
                class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    if (document.getElementById('member_ids')) {

        new TomSelect('#member_ids', {

            plugins: ['remove_button'],

            create: false,

            persist: false,

            hidePlaceholder: true,

            placeholder: 'Select Members'

        });

    }

});

</script>

@endpush
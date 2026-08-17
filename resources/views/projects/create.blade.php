@extends('layouts.app')

@section('title', 'Create Project')

@section('content')

<div class="page-header">

    <div>

        <h1>Create Project</h1>

        <p>Add a new project to TaskForge</p>

    </div>

    <div>

        <a href="{{ route('projects.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

<div class="form-card">

    <form action="{{ route('projects.store') }}" method="POST">

        @csrf

        {{-- Client --}}
        <div class="form-group">

            <label>

                Client <span class="text-danger">*</span>

            </label>

            <select
                name="client_id"
                class="form-control"
                required>

                <option value="">-- Select Client --</option>

                @foreach($clients as $client)

                    <option
                        value="{{ $client->id }}"
                        {{ old('client_id') == $client->id ? 'selected' : '' }}>

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
                value="{{ old('name') }}"
                placeholder="Enter project name">

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

                <option value="">-- Select Status --</option>

                <option
                    value="Pending"
                    {{ old('status') == 'Pending' ? 'selected' : '' }}>

                    Pending

                </option>

                <option
                    value="In Progress"
                    {{ old('status') == 'In Progress' ? 'selected' : '' }}>

                    In Progress

                </option>

                <option
                    value="Completed"
                    {{ old('status') == 'Completed' ? 'selected' : '' }}>

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
                    value="{{ old('start_date') }}">

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
                    value="{{ old('due_date') }}">

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
                        {{ collect(old('member_ids', []))->contains($member->id) ? 'selected' : '' }}>

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

                Save Project

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
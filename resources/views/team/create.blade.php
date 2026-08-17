@extends('layouts.app')

@section('title', 'Create Team Member')

@section('content')

<div class="page-header">

    <div>
        <h1>Create Team Member</h1>

        <p>
            Create a new user and assign a role to your workspace.
        </p>
    </div>

    <div>
        <a href="{{ route('team.index') }}" class="btn btn-secondary">
            ← Back to Team
        </a>
    </div>

</div>


<div class="card">

    <div class="card-header">
        <h2>Member Information</h2>
    </div>


    <div class="card-body">

        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>Please fix the following errors:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        <form action="{{ route('team.store') }}" method="POST">

            @csrf


            {{-- Name --}}
            <div class="form-group">

                <label for="name">
                    Name <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Enter member name"
                    required
                >

                @error('name')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Email --}}
            <div class="form-group">

                <label for="email">
                    Gmail <span class="required">*</span>
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="Enter Gmail address"
                    required
                >

                @error('email')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Role --}}
            <div class="form-group">

                <label for="role">
                    Role <span class="required">*</span>
                </label>

                <select
                    name="role"
                    id="role"
                    class="form-control @error('role') is-invalid @enderror"
                    required
                >

                    <option value="">Select Role</option>

                    <option
                        value="Admin"
                        {{ old('role') === 'Admin' ? 'selected' : '' }}
                    >
                        Admin
                    </option>

                    <option
                        value="Manager"
                        {{ old('role') === 'Manager' ? 'selected' : '' }}
                    >
                        Manager
                    </option>

                    <option
                        value="Member"
                        {{ old('role') === 'Member' ? 'selected' : '' }}
                    >
                        Member
                    </option>

                </select>

                @error('role')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Password --}}
            <div class="form-group">

                <label for="password">
                    Password <span class="required">*</span>
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter password"
                    required
                >

                @error('password')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Confirm Password --}}
            <div class="form-group">

                <label for="password_confirmation">
                    Confirm Password <span class="required">*</span>
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                    placeholder="Confirm password"
                    required
                >

            </div>


            {{-- Form Actions --}}
            <div class="form-actions">

                <a
                    href="{{ route('team.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Create Member
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
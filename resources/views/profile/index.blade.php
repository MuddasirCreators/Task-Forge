@extends('layouts.app')

@section('title', 'Settings')


@section('content')

{{-- Page Header --}}
<div class="tf-page-header mb-4">

    <div>

        <h1 class="tf-page-title">
            Settings
        </h1>

        <div class="tf-title-underline"></div>

        <p class="tf-page-subtitle mt-2">
            Manage your account information, phone number, and password.
        </p>

    </div>

</div>



{{-- Validation Errors --}}
@if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif



{{-- ================= USER INFORMATION ================= --}}

<div class="tf-card mb-4">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-person-circle"></i>

        </div>

        <h3 class="tf-card__title">
            Account Information
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

                    {{ $user->name }}

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

                    {{ $user->phone ?? 'Not provided' }}

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
                            Logged In
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



{{-- ================= UPDATE PHONE ================= --}}

<div class="tf-card mb-4">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-telephone"></i>

        </div>

        <h3 class="tf-card__title">
            Phone Number
        </h3>

    </div>


    <div class="tf-card__body">

        <p class="text-muted mb-4">

            Update the phone number associated with your account.

        </p>


        <form method="POST"
              action="{{ route('profile.phone.update') }}">

            @csrf

            @method('PATCH')


            <div class="form-group mb-3">

                <label for="phone">

                    Phone Number

                </label>


                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="03XXXXXXXXX"
                    maxlength="20"
                >


                @error('phone')

                    <small class="text-danger">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            <button type="submit"
                    class="tf-btn tf-btn--primary">

                <i class="bi bi-save"></i>

                Update Phone

            </button>

        </form>

    </div>

</div>



{{-- ================= CHANGE PASSWORD ================= --}}

<div class="tf-card mb-4">

    <div class="tf-card__header">

        <div class="tf-card__icon">

            <i class="bi bi-shield-lock"></i>

        </div>

        <h3 class="tf-card__title">
            Change Password
        </h3>

    </div>


    <div class="tf-card__body">

        <p class="text-muted mb-4">

            For security, enter your current password before setting a new password.

        </p>


        <form method="POST"
              action="{{ route('profile.password.update') }}">

            @csrf

            @method('PUT')


            {{-- Current Password --}}

            <div class="form-group mb-3">

                <label for="current_password">

                    Current Password

                </label>


                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    class="form-control"
                    autocomplete="current-password"
                >

<small class="text-muted">
    Password must be at least 8 characters and include uppercase,
    lowercase, number, and special character.
</small>
                @error('current_password')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>



            {{-- New Password --}}

            <div class="form-group mb-3">

                <label for="password">

                    New Password

                </label>


                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    autocomplete="new-password"
                >


                @error('password')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>



            {{-- Confirm Password --}}

            <div class="form-group mb-4">

                <label for="password_confirmation">

                    Confirm New Password

                </label>


                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    autocomplete="new-password"
                >

            </div>



            <button type="submit"
                    class="tf-btn tf-btn--primary">

                <i class="bi bi-key"></i>

                Change Password

            </button>

        </form>

    </div>

</div>



@endsection



@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>


/*
|--------------------------------------------------------------------------
| Success Messages
|--------------------------------------------------------------------------
*/

@if(session('status') === 'profile-updated')

    Swal.fire({

        icon: 'success',

        title: 'Profile Updated',

        text: 'Your profile information has been updated successfully.',

        timer: 2000,

        showConfirmButton: false

    });

@endif



@if(session('status') === 'phone-updated')

    Swal.fire({

        icon: 'success',

        title: 'Phone Updated',

        text: 'Your phone number has been updated successfully.',

        timer: 2000,

        showConfirmButton: false

    });

@endif



@if(session('status') === 'password-updated')

    Swal.fire({

        icon: 'success',

        title: 'Password Updated',

        text: 'Your password has been changed successfully.',

        timer: 2000,

        showConfirmButton: false

    });

@endif



@endpush
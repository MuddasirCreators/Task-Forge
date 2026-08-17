@extends('layouts.app')

@section('title', 'Edit Team Member')


@section('content')


{{-- Page Header --}}

<div class="tf-page-header mb-4">

    <div>

        <h1 class="tf-page-title">
            Edit Team Member
        </h1>

        <div class="tf-title-underline"></div>

        <p class="tf-page-subtitle mt-2">
            Update user account details.
        </p>

    </div>


    <div>

        <a href="{{ route('team.index') }}"
           class="tf-btn tf-btn--ghost">

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

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





<div class="tf-card">


<div class="tf-card__body">


<form action="{{ route('team.update', ['user'=>$user->id]) }}"
      method="POST">


@csrf

@method('PUT')





{{-- Name --}}

<div class="form-group mb-3">


<label>

Name
<span class="text-danger">*</span>

</label>



<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name',$user->name) }}">



@error('name')

<small class="text-danger">

{{ $message }}

</small>

@enderror


</div>





{{-- Email --}}

<div class="form-group mb-3">


<label>

Email
<span class="text-danger">*</span>

</label>



<input type="email"
       name="email"
       class="form-control"
       value="{{ old('email',$user->email) }}">



@error('email')

<small class="text-danger">

{{ $message }}

</small>

@enderror


</div>





{{-- Phone --}}

<div class="form-group mb-3">


<label>

Phone

</label>



<input type="text"
       name="phone"
       class="form-control"
       value="{{ old('phone',$user->phone) }}">



@error('phone')

<small class="text-danger">

{{ $message }}

</small>

@enderror


</div>





{{-- Role --}}

<div class="form-group mb-3">


<label>

Role
<span class="text-danger">*</span>

</label>



<select name="role"
        class="form-control">


<option value="Admin"
{{ old('role',$user->role) == 'Admin' ? 'selected' : '' }}>

Admin

</option>



<option value="Manager"
{{ old('role',$user->role) == 'Manager' ? 'selected' : '' }}>

Manager

</option>



<option value="Member"
{{ old('role',$user->role) == 'Member' ? 'selected' : '' }}>

Member

</option>



</select>



@error('role')

<small class="text-danger">

{{ $message }}

</small>

@enderror


</div>





{{-- Buttons --}}

<div class="mt-4">


<button type="submit"
        class="tf-btn tf-btn--primary">

<i class="bi bi-save"></i>

Update Member

</button>




<a href="{{ route('team.index') }}"
   class="tf-btn tf-btn--ghost">

Cancel

</a>


</div>



</form>


</div>


</div>



@endsection
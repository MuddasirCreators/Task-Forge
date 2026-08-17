@extends('layouts.app')

@section('title', 'Add Client')

@section('content')

<div class="page-header">

    <div>

        <h1>Add Client</h1>

        <p>Create a new client</p>

    </div>

    <div>

        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
            Back
        </a>

    </div>

</div>

@if ($errors->any())

<div class="alert alert-danger">

    <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

<div class="form-card">

    <form action="{{ route('clients.store') }}" method="POST">

        @csrf

        <div class="form-group">

            <label>Client Name</label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Contact Email</label>

            <input
                type="email"
                name="contact_email"
                value="{{ old('contact_email') }}"
                class="form-control">

        </div>

        <div class="form-buttons">

            <button type="submit" class="btn btn-success">
                Save Client
            </button>

            <a href="{{ route('clients.index') }}" class="btn btn-danger">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection
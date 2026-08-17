@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')

<div class="page-header">

    <div>

        <h1>Edit Client</h1>

        <p>Update client information</p>

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

    <form action="{{ route('clients.update', $client->id) }}" method="POST">

        @csrf

        @method('PUT')

        <div class="form-group">

            <label>Client Name</label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $client->name) }}"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Contact Email</label>

            <input
                type="email"
                name="contact_email"
                value="{{ old('contact_email', $client->contact_email) }}"
                class="form-control">

        </div>

        <div class="form-buttons">

            <button type="submit" class="btn btn-success">
                Update Client
            </button>

            <a href="{{ route('clients.index') }}" class="btn btn-danger">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection
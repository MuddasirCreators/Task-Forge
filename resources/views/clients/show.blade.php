@extends('layouts.app')

@section('title', 'View Client')

@section('content')

<div class="page-header">

    <div>

        <h1>Client Details</h1>

        <p>View client information</p>

    </div>

    <div>

        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
            Back
        </a>

        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">
            Edit
        </a>

    </div>

</div>

<div class="details-card">

    <table class="details-table">

        <tr>

            <th>ID</th>

            <td>{{ $client->id }}</td>

        </tr>

        <tr>

            <th>Client Name</th>

            <td>{{ $client->name }}</td>

        </tr>

        <tr>

            <th>Contact Email</th>

            <td>{{ $client->contact_email }}</td>

        </tr>

        <tr>

            <th>Created By</th>

            <td>{{ $client->creator->name ?? 'N/A' }}</td>

        </tr>

        <tr>

            <th>Created At</th>

            <td>{{ $client->created_at->format('d M Y h:i A') }}</td>

        </tr>

        <tr>

            <th>Last Updated</th>

            <td>{{ $client->updated_at->format('d M Y h:i A') }}</td>

        </tr>

    </table>

</div>

@endsection
@extends('layouts.app')

@section('title', 'Clients')

@section('content')

<div class="page-header">

    <div>

        <h1>Clients</h1>

        <p>Manage all clients of TaskForge</p>

    </div>

    <div>

        <a href="{{ route('clients.create') }}" class="btn btn-primary">

            + Add Client

        </a>

    </div>

</div>

<div class="table-card">

    <table class="table">

        <thead>

            <tr>

                <th>#</th>

                <th>Client Name</th>

                <th>Contact Email</th>

                <th>Created By</th>

                <th>Created At</th>

                <th width="220">Actions</th>

            </tr>

        </thead>

        <tbody>

            @forelse($clients as $client)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $client->name }}</td>

                    <td>{{ $client->contact_email }}</td>

                    <td>{{ $client->creator->name ?? 'N/A' }}</td>

                    <td>{{ $client->created_at->format('d M Y') }}</td>

                    <td>

                        <a href="{{ route('clients.show', $client) }}"
                           class="btn btn-info btn-sm">

                            View

                        </a>

                        <a href="{{ route('clients.edit', $client) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('clients.destroy', $client) }}"
                              method="POST"
                              class="delete-form"
                              style="display:inline;">

                            @csrf

                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center">

                        No Clients Found.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="pagination">

    {{ $clients->links() }}

</div>

@endsection

@push('scripts')

<script>

document.querySelectorAll('.delete-form').forEach(function(form){

    form.addEventListener('submit', function(e){

        e.preventDefault();

        Swal.fire({

            title: 'Are you sure?',

            text: 'You will not be able to recover this client.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Yes, Delete',

            cancelButtonText: 'Cancel'

        }).then((result) => {

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

</script>

@endpush
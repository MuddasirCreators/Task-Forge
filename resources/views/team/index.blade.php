@extends('layouts.app')

@section('title', 'Team Management')


@section('content')


{{-- Page Header --}}
<div class="tf-page-header mb-4">

    <div>

        <h1 class="tf-page-title">
            Team Management
        </h1>

        <div class="tf-title-underline"></div>

        <p class="tf-page-subtitle mt-2">
            Manage all system users and team members.
        </p>

    </div>


    <div>

        <a href="{{ route('team.create') }}"
           class="tf-btn tf-btn--primary">

            <i class="bi bi-person-plus"></i>

            Add User

        </a>

    </div>


</div>




{{-- Team Table --}}

<div class="tf-card">


<div class="table-responsive">


<table class="table tf-table">


<thead>

<tr>

<th>#</th>

<th>Name</th>

<th>Email</th>

<th>Phone</th>

<th>Role</th>

<th>Status</th>

<th>Created</th>

<th class="text-center">
Actions
</th>


</tr>

</thead>



<tbody>


@forelse($users as $user)


<tr>


<td>
{{ $loop->iteration }}
</td>



<td>

<div class="tf-assignee">


<div class="avatar-circle">

{{ strtoupper(substr($user->name,0,1)) }}

</div>


<strong>
{{ $user->name }}
</strong>


</div>

</td>




<td>
{{ $user->email }}
</td>




<td>

{{ $user->phone ?? 'N/A' }}

</td>




<td>

<span class="tf-badge">

{{ $user->role }}

</span>

</td>




<td>


@if($user->is_active)


<span class="badge bg-success">
Active
</span>


@else


<span class="badge bg-danger">
Inactive
</span>


@endif


</td>




<td>

{{ $user->created_at->format('d M Y') }}

</td>




<td class="text-center">


<div class="action-buttons">


{{-- View --}}

<a href="{{ route('team.show',$user) }}"
class="btn btn-sm btn-info"
title="View">

<i class="bi bi-eye"></i>

</a>



{{-- Edit --}}

<a href="{{ route('team.edit',$user) }}"
class="btn btn-sm btn-warning"
title="Edit">

<i class="bi bi-pencil"></i>

</a>





{{-- Activate / Deactivate --}}


@if($user->is_active)


<form action="{{ route('team.deactivate',$user) }}"
method="POST"
class="status-form d-inline">

@csrf

@method('PATCH')


<button type="submit"
class="btn btn-sm btn-danger"
title="Deactivate">

<i class="bi bi-person-x"></i>

</button>


</form>



@else



<form action="{{ route('team.activate',$user) }}"
method="POST"
class="status-form d-inline">


@csrf

@method('PATCH')


<button type="submit"
class="btn btn-sm btn-success"
title="Activate">

<i class="bi bi-person-check"></i>

</button>


</form>



@endif



</div>


</td>


</tr>



@empty


<tr>

<td colspan="8"
class="text-center">

No team members found.

</td>

</tr>


@endforelse



</tbody>


</table>


</div>


</div>





@if($users->hasPages())

<div class="mt-4">

{{ $users->links() }}

</div>

@endif





@endsection





@push('scripts')


{{-- SweetAlert CDN --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>


// Delete / Status Confirmation

document.querySelectorAll('.status-form').forEach(form => {


    form.addEventListener('submit', function(e){


        e.preventDefault();


        Swal.fire({

            title: 'Are you sure?',

            text: 'You want to change this user status.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Yes, Continue',

            cancelButtonText: 'Cancel'


        }).then((result)=>{


            if(result.isConfirmed){

                form.submit();

            }


        });


    });


});




// Success Message

@if(session('success'))

Swal.fire({

    title:'Success!',

    text:"{{ session('success') }}",

    icon:'success',

    timer:2000,

    showConfirmButton:false

});

@endif





// Error Message

@if(session('error'))

Swal.fire({

    title:'Error!',

    text:"{{ session('error') }}",

    icon:'error'

});

@endif



</script>


@endpush
@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7 col-lg-6">

            <div class="card border-0 shadow-sm">

                {{-- Header --}}
                <div class="card-header bg-white border-bottom py-3">

                    <div class="d-flex align-items-center">

                        <div
                            class="d-flex align-items-center justify-content-center rounded-circle bg-danger-subtle text-danger"
                            style="width:48px;height:48px;"
                        >
                            <i class="bi bi-trash3 fs-4"></i>
                        </div>

                        <div class="ms-3">

                            <h4 class="mb-1 fw-semibold">
                                Delete Task
                            </h4>

                            <small class="text-muted">
                                Task Management
                            </small>

                        </div>

                    </div>

                </div>


                {{-- Body --}}
                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <div
                            class="d-flex align-items-center justify-content-center mx-auto mb-3 rounded-circle bg-danger-subtle text-danger"
                            style="width:70px;height:70px;"
                        >
                            <i class="bi bi-exclamation-triangle fs-2"></i>
                        </div>

                        <h5 class="fw-semibold mb-2">
                            Are you sure?
                        </h5>

                        <p class="text-muted mb-0">
                            You are about to delete this task.
                            This action cannot be undone.
                        </p>

                    </div>


                    {{-- Task Information --}}
                    <div class="border rounded-3 p-3 mb-4 bg-light">

                        <div class="mb-2">

                            <small class="text-muted d-block">
                                Task
                            </small>

                            <strong>
                                {{ $task->title }}
                            </strong>

                        </div>


                        <div>

                            <small class="text-muted d-block">
                                Project
                            </small>

                            <strong>
                                {{ $project->name }}
                            </strong>

                        </div>

                    </div>


                    {{-- Delete Form --}}
                    <form
                        id="deleteTaskForm"
                        action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')


                        <div class="d-flex justify-content-end gap-2">

                            {{-- Cancel --}}
                            <a
                                href="{{ route('projects.tasks.show', [$project, $task]) }}"
                                class="btn btn-secondary"
                            >
                                <i class="bi bi-arrow-left me-1"></i>
                                Cancel
                            </a>


                            {{-- Delete --}}
                            <button
                                type="button"
                                id="confirmDeleteBtn"
                                class="btn btn-danger"
                            >
                                <i class="bi bi-trash3 me-1"></i>
                                Delete Task
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document
    .getElementById('confirmDeleteBtn')
    .addEventListener('click', function () {

        Swal.fire({

            title: 'Delete Task?',

            text: 'Are you sure you want to permanently delete this task? This action cannot be undone.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Yes, Delete Task',

            cancelButtonText: 'Cancel',

            reverseButtons: true

        }).then((result) => {

            if (result.isConfirmed) {

                document
                    .getElementById('deleteTaskForm')
                    .submit();

            }

        });

    });

</script>

@endsection
@extends('layouts.app')

@section('title', 'Time Logs')


@section('content')


<div class="page-header">

    <div>

        <h1>Time Logs</h1>

        <p>
            Track logged time for:
            <strong>{{ $task->title }}</strong>
        </p>

    </div>


    <div>

        <a href="{{ route('tasks.time-logs.create', $task) }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Time Log

        </a>

    </div>

</div>



<div class="card">


    <div class="card-body">


        <table class="table table-bordered table-hover">


            <thead>

                <tr>

                    <th>#</th>

                    <th>User</th>

                    <th>Minutes</th>

                    <th>Logged Date</th>

                    <th>Note</th>

                    <th width="150">
                        Actions
                    </th>

                </tr>

            </thead>



            <tbody>


            @forelse($timeLogs as $log)


                <tr>


                    <td>

                        {{ $loop->iteration }}

                    </td>


                    <td>

                        {{ $log->user->name }}

                    </td>



                    <td>

                        <span class="badge bg-primary">

                            {{ $log->minutes }} mins

                        </span>

                    </td>



                    <td>

                        {{ $log->logged_at->format('d M Y') }}

                    </td>



                    <td>

                        {{ $log->note ?? '-' }}

                    </td>



                    <td>


                        <a href="{{ route('time-logs.edit', $log) }}"
                           class="btn btn-sm btn-warning">

                            <i class="bi bi-pencil"></i>

                        </a>




                        <form
                            action="{{ route('time-logs.destroy', $log) }}"
                            method="POST"
                            class="d-inline">


                            @csrf

                            @method('DELETE')


                            <button
                                type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this time log?')">


                                <i class="bi bi-trash"></i>


                            </button>


                        </form>


                    </td>


                </tr>


            @empty


                <tr>


                    <td colspan="6" class="text-center">


                        <h5>
                            No Time Logs Found
                        </h5>


                        <p>
                            Start adding time entries for this task.
                        </p>


                    </td>


                </tr>


            @endforelse



            </tbody>


        </table>


    </div>


</div>



@if($timeLogs->hasPages())

    {{ $timeLogs->links() }}

@endif



@endsection
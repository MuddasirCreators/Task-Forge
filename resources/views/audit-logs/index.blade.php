@extends('layouts.app')

@section('content')

<div class="container">

    <div class="page-header">
        <h2>Audit Logs</h2>
    </div>


    <div class="card">

        <div class="card-body">

            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>

                    </thead>


                    <tbody>

                    @forelse($logs as $log)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>
                                {{ $log->user->name ?? 'System' }}
                            </td>


                            <td>
                                {{ ucfirst(str_replace('_',' ', $log->action)) }}
                            </td>


                            <td>

                                {{ class_basename($log->auditable_type) }}

                                <br>

                                ID:
                                {{ $log->auditable_id }}

                            </td>


                            <td>
                                {{ $log->description }}
                            </td>


                            <td>
                                {{ $log->created_at->format('d M Y h:i A') }}
                            </td>


                        </tr>


                    @empty

                        <tr>

                            <td colspan="6">
                                No audit logs found.
                            </td>

                        </tr>

                    @endforelse


                    </tbody>


                </table>

            </div>


            <div class="pagination">

                {{ $logs->links() }}

            </div>


        </div>

    </div>


</div>

@endsection
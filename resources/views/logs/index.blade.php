@extends('adminlte::page')

@section('title', 'Activity Logs')

@section('content_header')
    <h1 class="text-center mb-4">Activity Logs</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Logs Overview</h3>
        </div>
        <div class="card-body">
            <table id="activity-logs" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Caused By</th>
                        <th>Action</th>
                        <th>Performed On</th>
                        <th>Details</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $log->causer ? $log->causer->name . ' #' . $log->causer->id : 'System' }}
                            </td>
                            <td>{{ ucfirst($log->description) }}</td>
                            <td>
                                @if ($log->subject)
                                    {{ class_basename($log->subject_type) }}: {{ $log->subject->name ?? $log->subject->id }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#log-details-{{ $log->id }}">View</button>

                                <!-- Modal -->
                                <div class="modal fade" id="log-details-{{ $log->id }}" tabindex="-1" role="dialog" aria-labelledby="logDetailsLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="logDetailsLabel">Log Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <pre>{{ json_encode($log->properties->toArray(), JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#activity-logs').DataTable({
                "order": [[5, "desc"]],
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "search": "Filter logs:",
                    "lengthMenu": "Show _MENU_ entries",
                }
            });
        });
    </script>
@stop

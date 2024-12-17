@extends('adminlte::page')

@section('title', 'Rooms')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Rooms</h1>
            </div>

            @include('partials.breadcrumb', [
                'lists' => [
                    [
                        'link' => 'dashboard',
                        'name' => 'Dashboard',
                    ],
                    [
                        'link' => 'rooms.index',
                        'name' => 'Rooms',
                    ],
                ],
            ])
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ route('rooms.create') }}" class="btn bg-navy btn-tool">Create Room</a>
                </div>
            </div>
            <div class="card-body">
                <table id="laravel_datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Capacity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->description }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('bookings.show', $room->id) }}">View</a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('rooms.edit', $room->id) }}">Edit</a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@stop

@section('plugins.Datatables', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#laravel_datatable').DataTable();
        });
    </script>
@stop

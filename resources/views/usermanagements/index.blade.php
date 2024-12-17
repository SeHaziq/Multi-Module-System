@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6">
                <h1>User Management</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('usermanagements.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Create User
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Manage Users</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $user->roles->first()->name }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('usermanagements.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('usermanagements.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-circle"></i> No users found.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <small class="text-muted">Manage roles and permissions for each user effectively.</small>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge-info {
            font-size: 90%;
        }
    </style>
@stop

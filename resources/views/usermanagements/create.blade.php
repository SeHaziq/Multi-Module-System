@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <h1>Create New User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('usermanagements.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Enter name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Enter email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Enter password" required>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Enter confirm password" required>
                    </div>
                    <label for="role">Role:</label>
                    <select id="role" class="form-control" name="role" required>
                        <option value="" disabled selected>Select a role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create User</button>
            </form>
        </div>
    </div>
@stop

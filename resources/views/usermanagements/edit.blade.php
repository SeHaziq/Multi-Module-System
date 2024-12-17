@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('usermanagements.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" class="form-control" name="email" value="{{ $user->email }}" required>
                </div>

                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" class="form-control" name="role" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->first()->id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>
@stop

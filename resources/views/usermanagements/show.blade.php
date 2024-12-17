@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User: {{ $user->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Roles:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
            <p><strong>Permissions:</strong> {{ $user->permissions->pluck('name')->join(', ') }}</p>
        </div>
    </div>
@stop

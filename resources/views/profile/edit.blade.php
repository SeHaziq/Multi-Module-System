@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>{{ __('Profile') }}</h1>
@stop

@section('content')
    <div class="py-4">
        <div class="card mb-4">
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@stop

@extends('adminlte::page')

@section('title', 'Create Category')

@section('content_header')
    <h1>Create Category</h1>
@stop

@section('content')
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <!-- Category Name Field -->
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name')
                <p class="text-danger text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category Type Field -->
        <div class="form-group">
            <label for="type">Category Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
            @error('type')
                <p class="text-danger text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
@stop

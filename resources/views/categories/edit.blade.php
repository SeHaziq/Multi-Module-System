@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <h1>Edit Category</h1>
@stop

@section('content')
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <p class="text-danger text-xs">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
@stop

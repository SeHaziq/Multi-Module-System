@extends('adminlte::page')

@section('title', 'Edit Room')

@section('content')
<div class="container">
    <h1>Edit Room</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Room Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $room->name) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $room->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $room->capacity) }}" required>
        </div>
        <div class="form-group">
            <label for="image">Room Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($room->image)
                <p>Current Image:</p>
                <img src="{{ asset($room->image) }}" alt="Room Image" width="100">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

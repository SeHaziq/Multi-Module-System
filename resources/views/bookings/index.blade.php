@extends('adminlte::page')

@section('title', 'Room Bookings')

@section('content')
<div class="container">
    <h1 class="mb-4 text-dark font-weight-bold">Available Rooms</h1>

    <div class="row">
        @foreach($rooms as $room)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light rounded-lg">
                <div class="card-body">
                    <!-- Display room image if it exists -->
                    @if($room->image)
                    <img src="{{ asset($room->image) }}" class="card-img-top" alt="{{ $room->name }}" style="height: 200px; object-fit: cover;">
                    @else
                    <!-- If no image, display a placeholder or leave blank -->
                    <div style="height: 200px; background-color: #f0f0f0;"></div>
                    @endif

                    <h5 class="card-title font-weight-bold text-primary mt-3">{{ $room->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($room->description, 100) }}</p>
                    <a href="{{ route('bookings.show', $room->id) }}" class="btn btn-outline-primary btn-block mt-3 shadow-sm">View Room</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('css')
    <style>
        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
        }
        .card-body {
            background-color: #f9f9f9;
        }
        .btn-outline-primary {
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.2s ease-in-out;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
        }
    </style>
@stop

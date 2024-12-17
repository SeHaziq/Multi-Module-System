@extends('adminlte::page')

@section('title', $room->name)

@section('content')
<div class="content-header">
    <h1 class="mb-4 text-dark font-weight-bold">{{ $room->name }}</h1>
    <div class="mb-4" style="width: 100%; height: 0; padding-bottom: 35%; position: relative; background-color: #f0f0f0; border-radius: 8px; overflow: hidden;">
        @if($room->image)
            <img src="{{ asset($room->image) }}" alt="Room Image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        @endif
    </div>
    <p class="lead text-muted">{{ $room->description }}</p>
    <p><strong>Capacity:</strong> {{ $room->capacity }}</p>

    <h3 class="mt-5 mb-3">Existing Bookings</h3>
    @if($bookings->isEmpty())
        <p>No bookings for this room yet.</p>
    @else
        <ul class="list-unstyled">
            @foreach($bookings as $booking)
                <li class="mb-3">
                    <div class="card shadow-sm border-light rounded-lg p-3">
                        <p class="mb-1 font-weight-bold">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}:
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} -
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                        </p>
                        <small>Booked by: <strong>{{ $booking->user->name }}</strong></small>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <h3 class="mt-5 mb-3">Book This Room</h3>
    <form action="{{ route('bookings.store') }}" method="POST" class="bg-light p-4 rounded-lg shadow-sm">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">

        <div class="form-group">
            <label for="booking_date">Booking Date:</label>
            <input
                type="date"
                id="booking_date"
                name="booking_date"
                class="form-control"
                required
                min="{{ now()->format('Y-m-d') }}" <!-- This ensures only today or future dates are selectable -->
        </div>

        <div class="form-group">
            <label for="start_time">Start Time:</label>
            <input type="time" id="start_time" name="start_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time:</label>
            <input type="time" id="end_time" name="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block shadow-sm">Book Room</button>
    </form>
</div>
@endsection

@section('css')
    <style>
        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
        }
        .form-control {
            border-radius: 25px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
        }
        h3 {
            color: #555;
            font-size: 1.75rem;
        }
        .btn-primary {
            border-radius: 25px;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
@stop

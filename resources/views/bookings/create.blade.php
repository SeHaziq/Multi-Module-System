{{-- @extends('adminlte::page')

@section('title', 'Create Booking')

@section('content')
<div class="container mt-5">
    <h1 class="text-dark font-weight-bold mb-4">Create Booking</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" class="bg-light p-4 rounded-lg shadow-sm">
        @csrf
        <div class="form-group">
            <label for="room_id">Room</label>
            <select name="room_id" id="room_id" class="form-control" required>
                <option value="">Select a Room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->name }} (Capacity: {{ $room->capacity }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="booking_date">Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" value="{{ old('booking_date') }}" required>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block shadow-sm">Create Booking</button>
    </form>
</div>
@endsection

@section('css')
    <style>
        .form-control {
            border-radius: 25px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
        }
        .btn-primary {
            border-radius: 25px;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #007bff;
            color: white;
        }
        .alert-danger {
            border-radius: 15px;
        }
    </style>
@stop --}}

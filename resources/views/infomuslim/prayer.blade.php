@extends('adminlte::page')

@section('title', 'Prayer Times')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .prayer-table th {
            background-color: #343a40;
            color: #fff;
        }

        .prayer-table td {
            font-size: 1.1rem;
            vertical-align: middle;
        }

        .prayer-table tr.bg-warning td {
            background-color: #f39c12;
            color: white;
        }

        .live-time {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }

        .select2-container--default .select2-selection--single {
            height: 45px;
            line-height: 45px;
            font-size: 1rem;
        }

        .prayer-time-box {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .section-title {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Table Styles */
        .prayer-table {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }

        .prayer-time-box {
            width: 100%;
            max-width: 700px;  /* Limit the box width */
            margin: 20px auto;  /* Center the box */
        }

        /* Center the live time and prayer times section */
        .live-time {
            text-align: center;
            margin-bottom: 20px;
        }

        .section-subtitle {
            text-align: center;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#state').select2();

            setInterval(function() {
                var currentTime = new Date().toLocaleString("en-US", { timeZone: "Asia/Kuala_Lumpur" });
                $('#current-time').text(currentTime);
            }, 1000);
        });
    </script>
@stop

@section('content_header')
    <h1 class="text-center text-primary">Prayer Times</h1>
@stop

@section('content')

    <div class="box prayer-time-box mt-3">
        <div class="box-header with-border">
            <h3 class="section-title">{{ $state }} - {{ $currentDate }}</h3>
            <p class="section-subtitle"><strong>Islamic Date:</strong> {{ $islamicDate }}</p>
        </div>
        <div class="box-body">
            <p class="live-time"><strong>Current Time :</strong> <span id="current-time">{{ $currentTimeFormatted }}</span></p>

            <table class="table prayer-table table-bordered">
                <thead>
                    <tr>
                        <th>Prayer</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prayerTimes as $prayer => $time)
                        <tr class="{{ $prayer == $currentPrayer ? 'bg-warning' : '' }}">
                            <td>{{ $prayer }}</td>
                            <td>{{ \Carbon\Carbon::parse($time)->format('g:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($error))
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ $error }}
        </div>
    @endif


    <div class="box prayer-time-box">
        <div class="box-body">
            <form action="{{ route('prayertimes.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <label for="state">State</label>
                        <select name="state" id="state" class="form-control" required>
                            <option value="Kuala Lumpur" {{ old('state', $state) == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                            <option value="Johor" {{ old('state', $state) == 'Johor' ? 'selected' : '' }}>Johor</option>
                            <option value="Kedah" {{ old('state', $state) == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                            <option value="Kelantan" {{ old('state', $state) == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                            <option value="Melaka" {{ old('state', $state) == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                            <!-- Add other states here -->
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Get Prayer Time</button>
            </form>
        </div>
    </div>

@stop

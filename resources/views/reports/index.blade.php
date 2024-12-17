@extends('adminlte::page')

@section('title', 'Transaction Reports')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="mb-0">Transaction Reports</h1>
            </div>
            <div class="col-md-6 text-right">
                <!-- Download Button -->
                @if (!$transactions->isEmpty())
                    <a href="{{ route('reports.download', ['month' => $selectedMonth]) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                @endif
            </div>
        </div>

        <!-- Month Selector -->
        <form action="{{ route('reports.index') }}" method="GET" class="form-inline mb-4">
            <label for="month" class="mr-2">Select Month:</label>
            <input
                type="month"
                id="month"
                name="month"
                value="{{ $selectedMonth }}"
                class="form-control"
                onchange="this.form.submit()"
            >
        </form>

        @if ($transactions->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No transactions found for
                <strong>{{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</strong>.
            </div>
        @else
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Transactions for {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date->format('d M Y') }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->category->name }}</td>
                                    <td>
                                        <span class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            RM {{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $transaction->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

@extends('adminlte::page')

@section('title', 'Budgets')

@section('content_header')
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0">Budgets for {{ \Carbon\Carbon::parse($currentMonth)->format('F Y') }}</h1>
            </div>
            <div class="col-md-6 text-right">
                <form id="month-form" action="{{ route('budgets.index') }}" method="GET" class="d-flex justify-content-end align-items-center">
                    <button type="submit" name="month"
                        value="{{ \Carbon\Carbon::parse($currentMonth)->subMonth()->format('Y-m') }}"
                        class="btn btn-sm btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <input type="month" name="month" value="{{ $currentMonth }}"
                        class="form-control form-control-sm" id="month-picker" />
                    <button type="submit" name="month"
                        value="{{ \Carbon\Carbon::parse($currentMonth)->addMonth()->format('Y-m') }}"
                        class="btn btn-sm btn-secondary ml-2">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <!-- Budget Progress Section -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Budget Progress</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($setBudgets as $budget)
                        <div class="col-md-6 mb-4">
                            <div class="card border-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-1">{{ $budget->category->name }}</h5>
                                        <small class="text-muted">
                                            RM {{ number_format($budget->spent, 2) }} / RM {{ number_format($budget->amount, 2) }}
                                        </small>
                                    </div>
                                    @php
                                        $progress = $budget->amount > 0 ? ($budget->spent / $budget->amount) * 100 : 0;
                                        $progress = min($progress, 100); // Ensure it doesn't exceed 100%
                                    @endphp
                                    <div class="progress mt-2">
                                        <div class="progress-bar
                                            {{ $progress < 70 ? 'bg-success' : ($progress < 100 ? 'bg-warning' : 'bg-danger') }}"
                                            role="progressbar"
                                            style="width: {{ $progress }}%;"
                                            aria-valuenow="{{ $progress }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ number_format($progress, 0) }}%
                                        </div>
                                    </div>
                                    <div class="mt-3 d-flex justify-content-end">
                                        <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-sm btn-primary mr-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this budget?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Unset Budgets Section -->
        <div class="card shadow mt-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Unset Budgets</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Category</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unsetCategories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('budgets.create', ['category_id' => $category->id, 'month' => $currentMonth]) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Set Budget
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script>
        // Submit form when the month picker changes
        document.getElementById('month-picker').addEventListener('change', function() {
            document.getElementById('month-form').submit();
        });
    </script>
@stop

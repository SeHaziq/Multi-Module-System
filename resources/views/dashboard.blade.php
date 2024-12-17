@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>

            @include('partials.breadcrumb', [
                'lists' => [
                    [
                        'link' => 'dashboard.index',
                        'name' => 'Dashboard',
                    ],
                ],
            ])
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <!-- Small Box for Total Users -->
            <div class="col-lg-4 col-12">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ $totalUsers }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Small Box for All-Time Total Income -->
            <div class="col-lg-4 col-12">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ number_format($totalIncome, 2) }}</h3>
                        <p>All-Time Total Income</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Small Box for All-Time Total Expenses -->
            <div class="col-lg-4 col-12">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>{{ number_format($totalExpenses, 2) }}</h3>
                        <p>All-Time Total Expenses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Small Box for This Month's Total Income -->
            <div class="col-lg-4 col-12">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h3>{{ number_format($totalIncomeThisMonth, 2) }}</h3>
                        <p>This Month's Total Income</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Small Box for This Month's Total Expenses -->
            <div class="col-lg-4 col-12">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ number_format($totalExpensesThisMonth, 2) }}</h3>
                        <p>This Month's Total Expenses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Other Dashboard Information -->
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h3 class="card-title">Current Month Overview</h3>
                </div> --}}
                <div class="card-body">
                    <h5>Current Month: <strong>{{ $currentMonth }}</strong></h5>
                    <!-- Add more overview information here -->
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Pie Chart for Expenses -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expense Distribution of {{ $currentMonthName }} by Category</h3>
                    </div>
                    <div class="card-body text-center">
                        @if ($expensesByCategory->isEmpty())
                            <p class="text-center">You haven't spent any expenses this month.</p>
                        @else
                            <canvas id="expenseChart" style="max-width: 550px; max-height: 550px;"></canvas>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pie Chart for Income -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Income Distribution of {{ $currentMonthName }} by Category</h3>
                    </div>
                    <div class="card-body text-center">
                        @if ($incomeByCategory->isEmpty())
                            <p class="text-center">You haven't received any income this month.</p>
                        @else
                            <canvas id="incomeChart" style="max-width: 550px; max-height: 550px;"></canvas>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
@stop

@section('plugins.Chartjs', true)

@section('js')
    <script>
        // Data for expenses chart
        const expenseLabels = {!! json_encode($expensesByCategory->pluck('category.name')) !!};
        const expenseData = {!! json_encode($expensesByCategory->pluck('total')) !!};

        // Data for income chart
        const incomeLabels = {!! json_encode($incomeByCategory->pluck('category.name')) !!};
        const incomeData = {!! json_encode($incomeByCategory->pluck('total')) !!};

        // Configure the expenses chart
        const expenseCtx = document.getElementById('expenseChart').getContext('2d');
        new Chart(expenseCtx, {
            type: 'pie',
            data: {
                labels: expenseLabels,
                datasets: [{
                    label: 'Expenses by Category',
                    data: expenseData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Configure the income chart
        const incomeCtx = document.getElementById('incomeChart').getContext('2d');
        new Chart(incomeCtx, {
            type: 'pie',
            data: {
                labels: incomeLabels,
                datasets: [{
                    label: 'Income by Category',
                    data: incomeData,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
@stop

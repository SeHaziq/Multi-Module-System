@extends('adminlte::page')

@section('title', 'Edit Budget')

@section('content_header')
    <h1>Edit Budget for {{ $category->name }} - {{ \Carbon\Carbon::parse($currentMonth)->format('F Y') }}</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Budget</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" step="0.01" value="{{ $budget->amount }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Budget</button>
                </form>
            </div>
        </div>
    </section>
@stop

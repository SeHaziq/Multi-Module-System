@extends('adminlte::page')

@section('title', 'Set Budget')

@section('content_header')
    <h1>Set Budget for {{ \Carbon\Carbon::parse($currentMonth)->format('F Y') }}</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Set Budget</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('budgets.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="month" value="{{ $currentMonth }}">
                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" step="0.01" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Set Budget</button>
                </form>
            </div>
        </div>
    </section>
@stop

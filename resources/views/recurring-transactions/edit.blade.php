<!-- resources/views/recurring_transactions/edit.blade.php -->
@extends('adminlte::page')

@section('title', 'Edit Recurring Transaction')

@section('content')
    <div class="container-fluid">
        <h1>Edit Recurring Transaction</h1>
        <form action="{{ route('recurring_transactions.update', $recurringTransaction->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $recurringTransaction->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" class="form-control" step="0.01" value="{{ $recurringTransaction->amount }}" required>
            </div>

            <div class="form-group">
                <label for="interval">Interval</label>
                <select name="interval" class="form-control" required>
                    <option value="daily" {{ $recurringTransaction->interval == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ $recurringTransaction->interval == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ $recurringTransaction->interval == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $recurringTransaction->interval == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $recurringTransaction->start_date }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control">{{ $recurringTransaction->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Recurring Transaction</button>
        </form>
    </div>
@endsection

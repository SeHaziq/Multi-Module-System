@extends('adminlte::page')

@section('title', 'Recurring Transactions')

@section('content_header')
    <h1>Recurring Transactions</h1>
@stop

@section('content')
    <a href="{{ route('recurring-transactions.create') }}" class="btn btn-success mb-3">Add New Recurring Transaction</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recurringTransactions as $recurringTransaction)
                <tr>
                    <td>{{ $recurringTransaction->id }}</td>
                    <td>{{ $recurringTransaction->category->name }}</td>
                    <td>{{ $recurringTransaction->amount }}</td>
                    <td>{{ ucfirst($recurringTransaction->type) }}</td>
                    <td>{{ $recurringTransaction->description }}</td>
                    <td>
                        <a href="{{ route('recurring-transactions.edit', $recurringTransaction->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('recurring-transactions.destroy', $recurringTransaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

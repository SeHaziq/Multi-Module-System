@extends('adminlte::page')
@section('title', 'Transaction Details')

@section('content_header')
    <h1>Transaction Details</h1>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction #{{ $transactions->id }}</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Category</dt>
                    <dd class="col-sm-8">{{ $transactions->category->name ?? 'N/A' }}</dd>

                    <dt class="col-sm-4">Amount</dt>
                    <dd class="col-sm-8">{{ number_format($transactions->amount, 2) }}</dd>

                    <dt class="col-sm-4">Type</dt>
                    <dd class="col-sm-8">{{ ucfirst($transactions->type) }}</dd>

                    <dt class="col-sm-4">Date</dt>
                    <dd class="col-sm-8">{{ $transactions->date->format('d-m-Y') }}</dd>

                    <dt class="col-sm-4">Description</dt>
                    <dd class="col-sm-8">{{ $transactions->description ?? 'No description provided' }}</dd>
                </dl>
            </div>
            <div class="card-footer">
                <a href="{{ route('transactions') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('transactions.edit', $transactions->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('transactions.destroy', $transactions->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                </form>
            </div>
        </div>
    </section>
@stop

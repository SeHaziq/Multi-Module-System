@extends('adminlte::page')
@section('title', 'Transaction | SPOT Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Edit Transaction</h1>
            </div>
            @include('partials.breadcrumb', [
                'lists' => [
                    [
                        'link' => 'dashboard',
                        'name' => 'Dashboard',
                    ],
                    [
                        'link' => 'transactions',
                        'name' => 'Transactions',
                    ],
                ],
            ])
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ route('transactions.create') }}" class="btn bg-navy btn-tool">Add New Transaction</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.update', ['transactions' => $transactions->id]) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    <div class="col-md-6">
                        <!-- Category Dropdown -->
                        <div class="form-group">
                            <label for="category_id" class="form-control-label">Category</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $transactions->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-danger text-xs pt-1"> {{ $message }} </p> @enderror
                        </div>

                        <!-- Amount Input -->
                        <div class="form-group">
                            <label for="amount" class="form-control-label">Amount</label>
                            <input class="form-control" type="number" name="amount" step="0.01" value="{{ $transactions->amount }}" required>
                            @error('amount') <p class="text-danger text-xs pt-1"> {{ $message }} </p> @enderror
                        </div>

                        <!-- Type (Income/Expense) -->
                        <div class="form-group">
                            <label for="type" class="form-control-label">Transaction Type</label>
                            <select class="form-control" name="type" required>
                                <option value="">Select Type</option>
                                <option value="income" {{ $transactions->type == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ $transactions->type == 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('type') <p class="text-danger text-xs pt-1"> {{ $message }} </p> @enderror
                        </div>

                        <!-- Date Input -->
                        <div class="form-group">
                            <label for="date" class="form-control-label">Date</label>
                            <input class="form-control" type="date" name="date" value="{{ $transactions->date->format('Y-m-d') }}" required>
                            @error('date') <p class="text-danger text-xs pt-1"> {{ $message }} </p> @enderror
                        </div>

                        <!-- Description Input -->
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description</label>
                            <textarea class="form-control" name="description" rows="4">{{ $transactions->description }}</textarea>
                            @error('description') <p class="text-danger text-xs pt-1"> {{ $message }} </p> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('plugins.Toastr', true)

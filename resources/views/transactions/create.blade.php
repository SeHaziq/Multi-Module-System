@extends('adminlte::page')

@section('title', 'Tambah Transaksi')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Add Transaction</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Transaction</h3>
            </div>
            <div class="card-body">
                <form role="form" method="POST" action="{{ route('transactions.store') }}">
                    @csrf
                    <div class="col-md-6">
                        <!-- Type (Income/Expense) First -->
                        <div class="form-group">
                            <label for="type" class="form-control-label">Transaction Type</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value="">Select Type</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                            @error('type')
                                <p class="text-danger text-xs pt-1"> {{$message}} </p>
                            @enderror
                        </div>

                        <!-- Category Dropdown - Initially Empty -->
                        <div class="form-group">
                            <label for="category_id" class="form-control-label">Category</label>
                            <select class="form-control" name="category_id" id="category_id" required>
                                <option value="">Select Category</option>
                                <!-- Categories will be updated dynamically -->
                            </select>
                            @error('category_id')
                                <p class="text-danger text-xs pt-1"> {{$message}} </p>
                            @enderror
                        </div>

                        <!-- Amount Input -->
                        <div class="form-group">
                            <label for="amount" class="form-control-label">Amount</label>
                            <input class="form-control" type="number" name="amount" step="0.01" required>
                            @error('amount')
                                <p class="text-danger text-xs pt-1"> {{$message}} </p>
                            @enderror
                        </div>

                        <!-- Date Input -->
                        <div class="form-group">
                            <label for="date" class="form-control-label">Date</label>
                            <input class="form-control" type="date" name="date" required>
                            @error('date')
                                <p class="text-danger text-xs pt-1"> {{$message}} </p>
                            @enderror
                        </div>

                        <!-- Description Input -->
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description</label>
                            <textarea class="form-control" name="description" rows="4"></textarea>
                            @error('description')
                                <p class="text-danger text-xs pt-1"> {{$message}} </p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Submit</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </section>
@stop

@section('plugins.Toastr', true)

@section('js')
<script>
    // Store categories in JavaScript
    const categories = @json($categories);

    // Update categories based on selected transaction type
    document.getElementById('type').addEventListener('change', function() {
        var selectedType = this.value; // Get selected type (income or expense)

        // Filter categories based on selected type
        var filteredCategories = categories.filter(category => category.type === selectedType);

        // Update the category dropdown
        var categorySelect = document.getElementById('category_id');
        categorySelect.innerHTML = '<option value="">Select Category</option>'; // Reset options

        // Populate the dropdown with filtered categories
        filteredCategories.forEach(function(category) {
            var option = document.createElement('option');
            option.value = category.id;
            option.text = category.name;
            categorySelect.appendChild(option);
        });
    });
</script>
@stop

@extends('adminlte::page')

@section('title', 'Transaction')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Transaction</h1>
            </div>

            @include('partials.breadcrumb', [
                'lists' => [
                    [
                        'link' => 'dashboard',
                        'name' => 'Dashboard',
                    ],
                    [
                        'link' => 'transactions.index',
                        'name' => 'Transaction',
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
                    <a href="{{ route('transactions.create') }}" class="btn bg-navy btn-tool">Add Transaction</a>
                </div>
            </div>
            <div class="card-body">
                <table id="laravel_datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->category->name }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    <span class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->date ? $transaction->date->format('d-m-Y') : 'N/A' }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('transactions.show', $transaction->id) }}">Lihat</a>
                                    <a class="btn btn-info btn-sm" href="{{ route('transactions.edit', $transaction->id) }}">Kemaskini</a>
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@stop

@section('plugins.Toastr', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(document).ready(function() {
            $('#laravel_datatable').DataTable();
        });

        $('.delete').on('click', function(event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal.fire({
                title: 'Anda pasti untuk padam rekod ini?',
                text: 'Rekod ini dan maklumatnya akan dipadam!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Yes',
                preConfirm: false
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                    console.log('berjaya');
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    // Handle cancel case
                }
            });
        });
    </script>
@stop

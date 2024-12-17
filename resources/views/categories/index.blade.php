@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Categories</h1>
            </div>
            @include('partials.breadcrumb', [
                'lists' => [
                    [
                        'link' => 'dashboard',
                        'name' => 'Dashboard',
                    ],
                    [
                        'link' => 'categories.index',
                        'name' => 'Categories',
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
                    <a href="{{ route('categories.create') }}" class="btn bg-navy btn-tool">Add New Category</a>
                </div>
            </div>
            <div class="card-body">
                <table id="laravel_datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <span class="{{ $category->type == 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ ucfirst($category->type) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-info btn-sm">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
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

@section('plugins.Datatables', true)

@section('js')
    <script>
        $(document).ready(function() {
            $('#laravel_datatable').DataTable();
        });
    </script>
@stop

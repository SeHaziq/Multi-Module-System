@extends('adminlte::page')

@section('title', 'Send Email')

@section('content_header')
    <h1>Send an Email</h1>
@stop

@section('content')
    <!-- Display Success Message -->
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        <!-- Meta Refresh for Redirect -->
        <meta http-equiv="refresh" content="5;url={{ route('papar.borang.email') }}">
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Email Form</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('hantar.email') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="tajuk_email">Email Subject:</label>
                    <input type="text" name="tajuk_email" id="tajuk_email" class="form-control" placeholder="Enter email subject" required>
                </div>

                <div class="form-group">
                    <label for="kandungan_email">Email Content:</label>
                    <textarea name="kandungan_email" id="kandungan_email" class="form-control" rows="5" placeholder="Enter email content" required></textarea>
                </div>

                <div class="form-group">
                    <label for="attachments">Attachments:</label>
                    <input type="file" name="attachments[]" id="attachments" class="form-control-file" multiple>
                    <small class="text-muted">You can upload multiple files.</small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
@stop

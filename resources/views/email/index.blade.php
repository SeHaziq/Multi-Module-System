@extends('adminlte::page')

@section('title', 'Email')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
</head>
<body>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('emails.send') }}">
        @csrf
        <div>
            <label for="email_subject">Subject:</label>
            <input type="text" id="email_subject" name="email_subject" required>
        </div>
        <div>
            <label for="email_content">Content:</label>
            <textarea id="email_content" name="email_content" rows="5" required></textarea>
        </div>
        <div>
            <label for="users">Select Users:</label>
            <select id="users" name="users[]" multiple required>
                @foreach ($users as $user)
                    <option value="{{ $user->email }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Send Email</button>
    </form>

</body>
</html>


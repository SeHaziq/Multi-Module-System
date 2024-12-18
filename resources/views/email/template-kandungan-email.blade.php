<!-- resources/views/email/template-kandungan-email.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>{{ $tajukEmail }}</title>
</head>
<body>
    <h1>{{ $tajukEmail }}</h1>
    <p>{!! nl2br(e($kandunganEmail)) !!}</p>
</body>
</html>

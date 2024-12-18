<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
<body>
    <h3>{{ $subjectEmail }}</h3>
    <p>{!! nl2br(e($contentEmail)) !!}</p>
</body>
</html>

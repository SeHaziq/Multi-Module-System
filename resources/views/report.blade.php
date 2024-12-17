<!DOCTYPE html>
<html>
<head>
    <title>Report Preview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Generated on: {{ $date }}</p>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Example Item</td>
                <td>$100</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="{{ route('report.download') }}" class="btn btn-primary">Download as PDF</a>
    </div>
</body>
</html>

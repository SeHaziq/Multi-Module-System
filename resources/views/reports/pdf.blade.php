<!DOCTYPE html>
<html>
<head>
    <title>Transaction Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Transaction Report for {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</h1>

    @if ($transactions->isEmpty())
        <p>No transactions found for this period.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('d M Y') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ $transaction->category->name }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>

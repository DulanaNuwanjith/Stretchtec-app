<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Yarn Supplier Spending Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h2>Yarn Supplier Spending Report</h2>
    <p>From: {{ $start_date }} To: {{ $end_date }}</p>

    <table>
        <thead>
            <tr>
                <th>Yarn Supplier</th>
                <th>Total Yarn Ordered (g)</th>
                <th>Total Spent</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->yarnSupplier ?? 'Unknown' }}</td>
                    <td>{{ number_format($supplier->total_weight, 0) }}g</td>
                    <td>{{ number_format($supplier->total_spent, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reject Report - {{ $rejectNo }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 10px;
            color: #000;
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 14px;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h1>Reject Report</h1>
<h2>Reject No: {{ $rejectNo }}</h2>
<h2>Customer(s): {{ $customerNames }}</h2>
<h2>Coordinator(s): {{ $coordinatorNames }}</h2>

<table>
    <thead>
    <tr>
        <th>Order No</th>
        <th>Customer Decision</th>
        <th>Total Yarn Price</th>
    </tr>
    </thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $order['orderNos'] }}</td>
            <td>{{ $order['customerDecision'] ?: 'N/A' }}</td>
            <td>{{ number_format($order['total_yarn_price'], 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No records found for this reject number.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<p class="summary">
    Total Orders: {{ $orders->count() }}<br>
    Total Rejections (Order Rejected):
    {{ $orders->filter(fn($o) => str_contains($o['customerDecision'], 'Order Rejected'))->count() }}<br>
    Total Yarn Price: {{ number_format($orders->sum('total_yarn_price'), 2) }}
</p>

</body>

</html>

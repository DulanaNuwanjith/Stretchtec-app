<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Reject Report - {{ $customerName }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 10px;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h1>Customer Reject Report</h1>
<h2>Customer: {{ $customerName }}</h2>
<h2>From: {{ $start_date }} To: {{ $end_date }}</h2>

@foreach ($rejectGroups as $rejectNo => $group)
    <h2>Reject No: {{ $rejectNo }}</h2>

    <table>
        <thead>
        <tr>
            <th>Order No</th>
            <th>Customer Decision</th>
            <th>Total Yarn Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($group['orders'] as $order)
            <tr>
                <td>{{ $order['orderNo'] }}</td>
                <td>{{ $order['customerDecision'] ?: 'N/A' }}</td>
                <td>{{ number_format($order['total_yarn_price'], 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="summary">
        Total Orders: {{ $group['total_orders'] }}<br>
        Total Rejections (Order Rejected): {{ $group['total_rejections'] }}<br>
        Total Yarn Price: {{ number_format($group['total_yarn_price'], 2) }}
    </p>
    <hr>
@endforeach
</body>
</html>

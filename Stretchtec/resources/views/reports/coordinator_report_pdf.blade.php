<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Coordinator Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            padding: 10px;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
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
            font-weight: bold;
            margin-bottom: 20px;
        }

        hr {
            border: 1px solid #000;
            margin: 20px 0;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-received {
            background-color: #d4edda;
            color: #155724;
        }

        .status-not-received {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-pending {
            background-color: #e2e3e5;
            color: #383d41;
        }
    </style>
</head>

<body>

    <h1>Coordinators Summary Report</h1>
    <p style="text-align:center;">From: {{ $startDate }} | To: {{ $endDate }}</p>

    @foreach ($report as $coordinator => $data)
        <h2>{{ $coordinator }}</h2>

        <table>
            <thead>
                <tr>
                    <th>Order No</th>
                    <th>Inquiry Received</th>
                    <th>Customer</th>
                    <th>Customer Delivery</th>
                    <th>Customer Decision</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['orders'] as $order)
                    @php
                        $status = $order->customerDecision;
                        $colorClass = match ($status) {
                            'Order Rejected' => 'status-rejected',
                            'Order Received' => 'status-received',
                            'Order Not Received' => 'status-not-received',
                            'Pending' => 'status-pending',
                            default => '',
                        };
                    @endphp
                    <tr class="{{ $colorClass }}">
                        <td>{{ $order->orderNo }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->inquiryReceiveDate)->format('Y-m-d') }}</td>
                        <td>{{ $order->customerName }}</td>
                        <td>{{ $order->customerDeliveryDate ? \Carbon\Carbon::parse($order->customerDeliveryDate)->format('Y-m-d') : '-' }}
                        </td>
                        <td>{{ $order->customerDecision }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="summary">
            Total Orders: {{ $data['total_orders'] }} |
            Rejected: {{ $data['rejected_count'] }} |
            Received: {{ $data['received_count'] }} |
            Not Received: {{ $data['not_received_count'] }} |
            Pending: {{ $data['pending_count'] }}
        </p>

        <hr>
    @endforeach

</body>

</html>

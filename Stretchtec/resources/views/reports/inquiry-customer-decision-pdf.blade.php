<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Inquiry Sample Customer Decision Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1,
        h3 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Inquiry Sample Customer Decision Report</h1>
    <p style="text-align:center;">
        Date Range: {{ $start_date }} to {{ $end_date }}<br>
        @if ($customer)
            Customer: {{ $customer }}
        @else
            Customer: All
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>Order No</th>
                <th>Customer</th>
                <th>Inquiry Date</th>
                <th>Customer Delivery Date</th>
                <th>Customer Decision</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inquiries as $inq)
                <tr>
                    <td>{{ $inq->orderNo }}</td>
                    <td>{{ $inq->customerName }}</td>
                    <td>{{ \Carbon\Carbon::parse($inq->inquiryReceiveDate)->format('Y-m-d') }}</td>
                    <td>
                        @if ($inq->customerDeliveryDate)
                            {{ \Carbon\Carbon::parse($inq->customerDeliveryDate)->format('Y-m-d') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $inq->customerDecision }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>

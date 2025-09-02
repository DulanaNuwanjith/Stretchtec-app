@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <title>Sample Reference Delivery Report</title>
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

        p {
            text-align: center;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<h1>Reference Delivery Report</h1>
<p>
    Date Range: {{ $startDate }} to {{ $endDate }}
</p>

<table>
    <thead>
    <tr>
        <th>Reference No</th>
        <th>Inquiry Receive Date</th>
        <th>Customer Name</th>
        <th>Customer Delivery Date</th>
        <th>Delivery Qty</th>
    </tr>
    </thead>
    <tbody class="text-center">
    @forelse ($inquiries as $inquiry)
        <tr>
            <td>{{ $inquiry->referenceNo ?? '-' }}</td>
            <td>{{ $inquiry->inquiryReceiveDate ? Carbon::parse($inquiry->inquiryReceiveDate)->format('Y-m-d') : 'N/A' }}</td>
            <td>{{ $inquiry->customerName ?? '-' }}</td>
            <td>{{ $inquiry->customerDeliveryDate ? Carbon::parse($inquiry->customerDeliveryDate)->format('Y-m-d') : 'N/A' }}</td>
            <td>{{ $inquiry->deliveryQty ?? '-' }}</td>
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

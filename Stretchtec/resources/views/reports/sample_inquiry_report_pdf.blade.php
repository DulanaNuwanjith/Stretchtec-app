<!DOCTYPE html>
<html>
<head>
    <title>Sample Inquiry Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2, p {
            margin: 0;
            padding: 0;
        }

        h2 {
            margin-bottom: 5px;
        }

        p {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            font-size: 11px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<h2>Sample Inquiry Report</h2>
<p><strong>From:</strong> {{ $start_date }} <strong>To:</strong> {{ $end_date }}</p>
@if(!empty($coordinators))
    <p><strong>Coordinator(s):</strong> {{ implode(', ', $coordinators) }}</p>
@endif

<table>
    <thead>
    <tr>
        <th>Order No</th>
        <th>Inquiry Date</th>
        <th>Customer Name</th>
        <th>Merchandiser Name</th>
        <th>Item</th>
        <th class="w-14">Reference No</th>
        <th>Item Description</th>
        <th>Size</th>
        <th>Color</th>
        <th>Style</th>
        <th>Customer Requested Qty</th>
        <th>Customer Requested Date</th>
        <th>Develop Planned Date</th>
        <th>Production Status</th>
        <th>Delivery Qty</th>
        <th>Customer Delivery Date</th>
        <th>Shade</th>
        <th>TKT</th>
        <th>Customer Decision</th>
    </tr>
    </thead>
    <tbody>
    @forelse($inquiries as $inq)
        <tr>
            <td>{{ $inq->orderNo }}</td>
            <td>{{ $inq->inquiryReceiveDate ? $inq->inquiryReceiveDate->format('Y-m-d') : '-' }}</td>
            <td>{{ $inq->customerName ?? '-' }}</td>
            <td>{{ $inq->merchandiseName ?? '-' }}</td>
            <td>{{ $inq->item ?? '-' }}</td>
            <td>{{ $inq->referenceNo ?? '-' }}</td>
            <td>{{ $inq->ItemDiscription ?? '-' }}</td>
            <td>{{ $inq->size ?? '-' }}</td>
            <td>{{ $inq->color ?? '-' }}</td>
            <td>{{ $inq->style ?? '-' }}</td>
            <td>{{ $inq->sampleQty ?? '-' }}</td>
            <td>{{ $inq->customerRequestDate ? $inq->customerRequestDate->format('Y-m-d') : '-' }}</td>
            <td>{{ $inq->developPlannedDate ? $inq->developPlannedDate->format('Y-m-d') : '-' }}</td>
            <td>{{ $inq->productionStatus ?? '-' }}</td>
            <td>{{ $inq->deliveryQty ?? '-' }}</td>
            <td>{{ $inq->customerDeliveryDate ? $inq->customerDeliveryDate->format('Y-m-d') : '-' }}</td>
            <td>{{ $inq->samplePreparationRnD->shade ?? '-' }}</td>
            <td>{{ $inq->samplePreparationRnD->tkt ?? '-' }}</td>
            <td>{{ $inq->customerDecision ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="19" style="text-align:center;">No records found</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>

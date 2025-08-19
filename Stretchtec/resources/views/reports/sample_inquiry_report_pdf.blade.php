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
        h2 { margin-bottom: 5px; }
        p { margin-bottom: 10px; }
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
        tr { page-break-inside: avoid; page-break-after: auto; }
        .page-break { page-break-after: always; }
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
                <th>Reference No</th>
                <th>Coordinator</th>
                <th>Inquiry Date</th>
                <th>Item</th>
                <th>Item Description</th>
                <th>Size</th>
                <th>Qty Ref</th>
                <th>Color</th>
                <th>Shade</th>
                <th>TKT</th>
                <th>Yarn Supplier</th>
                <th>Style</th>
                <th>Customer Delivery Date</th>
                <th>Delivery Qty</th>
                <th>Customer Decision</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inquiries as $inq)
                <tr>
                    <td>{{ $inq->orderNo }}</td>
                    <td>{{ $inq->referenceNo ?? '-' }}</td>
                    <td>{{ $inq->coordinatorName ?? '-' }}</td>
                    <td>{{ $inq->inquiryReceiveDate ? $inq->inquiryReceiveDate->format('Y-m-d') : '-' }}</td>
                    <td>{{ $inq->item ?? '-' }}</td>
                    <td>{{ $inq->ItemDiscription ?? '-' }}</td>
                    <td>{{ $inq->size ?? '-' }}</td>
                    <td>{{ $inq->qtRef ?? '-' }}</td>
                    <td>{{ $inq->color ?? '-' }}</td>
                    <td>{{ $inq->samplePreparationRnD->shade ?? '-' }}</td>
                    <td>{{ $inq->samplePreparationRnD->tkt ?? '-' }}</td>
                    <td>{{ $inq->samplePreparationRnD->yarnSupplier ?? '-' }}</td>
                    <td>{{ $inq->style ?? '-' }}</td>
                    <td>{{ $inq->customerDeliveryDate ? $inq->customerDeliveryDate->format('Y-m-d') : '-' }}</td>
                    <td>{{ $inq->deliveryQty ?? '-' }}</td>
                    <td>{{ $inq->customerDecision ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" style="text-align:center;">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

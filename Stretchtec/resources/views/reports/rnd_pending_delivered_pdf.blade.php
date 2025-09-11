<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RnD Pending/Delivered Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 12px; }
        h2 { text-align: center; margin: 3px 0; }
        .meta { margin: 6px 0 10px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; word-wrap: break-word; }
        th, td { border: 1px solid #000; padding: 6px; vertical-align: top; font-size: 10px; }
        th { background: #f2f2f2; font-weight: 700; }
        .footer { position: fixed; bottom: 6px; left: 0; right: 0; text-align: center; font-size: 9px; }
        .small { font-size: 10px; }
    </style>
</head>
<body>

@php
    // Accept either $rndRecords (controller used) or $records (alternative).
    $records = $rndRecords ?? ($records ?? collect());

    // safe fallbacks for other variables (controller may pass different names)
    $start_date = $start_date ?? ($startDate ?? 'N/A');
    $end_date = $end_date ?? ($endDate ?? 'N/A');
    $selectedCoordinators = $selectedCoordinators ?? ($selectedCoordinators ?? ($coordinators ?? []));
    $selectedStatuses = $selectedStatus ?? ($selectedStatuses ?? ($status ?? []));
@endphp

<h2>RnD Pending / Delivered Report</h2>

<div class="meta">
    <strong>From:</strong> {{ $start_date }} &nbsp;&nbsp;
    <strong>To:</strong> {{ $end_date }} &nbsp;&nbsp;
    <strong>Coordinators:</strong> {{ !empty($selectedCoordinators) ? implode(', ', (array)$selectedCoordinators) : 'All' }} &nbsp;&nbsp;
    <strong>Status:</strong> {{ !empty($selectedStatuses) ? implode(', ', (array)$selectedStatuses) : 'All' }}
</div>

<table>
    <thead>
        <tr>
            <th>Order No</th>
            <th>Customer</th>
            <th>Item</th>
            <th>Size</th>
            <th>Color</th>
            <th>Shade</th>
            <th>TKT</th>
            <th>Already Developed</th>
            <th>Customer Request Date</th>
            <th>Colour Sent</th>
            <th>Colour Received</th>
            <th>Yarn Ordered Date</th>
            <th>Yarn PO No</th>
            <th>Yarn Status</th>
            <th>Production Deadline</th>
            <th>Send to Prod (date/time)</th>
            <th>Production Status</th>
            <th>Reference No</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $i => $rec)
            @php
                // unify fields (some data exists on RnD, some on linked SampleInquiry)
                $orderNo = $rec->orderNo ?? ($rec->sampleInquiry->orderNo ?? '-');
                $customer = $rec->sampleInquiry->customerName ?? '-';
                $coordinator = $rec->sampleInquiry->coordinatorName ?? '-';
                $item = $rec->sampleInquiry->item ?? '-';
                $size = $rec->sampleInquiry->size ?? '-';
                $colour = $rec->sampleInquiry->color ?? '-';
                $shade = $rec->shade ?? ($rec->sampleInquiry->samplePreparationRnD->shade ?? ($rec->sampleInquiry->shade ?? '-')) ?? '-';
                $tkt = $rec->tkt ?? '-';

                // shadeOrders counts
                $pendingYarns = method_exists($rec, 'shadeOrders') ? $rec->shadeOrders->where('status', 'Pending')->count() : 0;
                $receivedYarns = method_exists($rec, 'shadeOrders') ? $rec->shadeOrders->whereIn('status', ['Yarn Received','Sent to Production','In Production','Production Complete','Dispatched to RnD','Delivered'])->count() : 0;

                // helper date format
                $d = fn($val) => $val ? (\Carbon\Carbon::parse($val)->format('Y-m-d')) : '-';
                $dt = fn($val) => $val ? (\Carbon\Carbon::parse($val)->format('Y-m-d H:i')) : '-';
            @endphp
            <tr>
                <td class="small">{{ $orderNo }}</td>
                <td class="small">{{ $customer }}</td>
                <td class="small">{{ $item }}</td>
                <td class="small">{{ $size }}</td>
                <td class="small">{{ $colour }}</td>
                <td class="small">{{ $shade }}</td>
                <td class="small">{{ $tkt }}</td>
                <td class="small">{{ $rec->alreadyDeveloped ?? '-' }}</td>
                <td class="small">{{ $d($rec->customerRequestDate) }}</td>
                <td class="small">{{ $dt($rec->colourMatchSentDate) }}</td>
                <td class="small">{{ $dt($rec->colourMatchReceiveDate) }}</td>
                <td class="small">{{ $dt($rec->yarnOrderedDate) }}</td>
                <td class="small">{{ $rec->yarnOrderedPONumber ?? '-' }}</td>
                <td class="small">
                    @if($rec->alreadyDeveloped !== null && $rec->alreadyDeveloped !== 'Need to Develop')
                        —
                    @else
                        @if($rec->shadeOrders->isNotEmpty())
                            @if($pendingYarns)
                                Pending ({{ $pendingYarns }})
                            @else
                                Received ({{ $receivedYarns }})
                            @endif
                        @else
                            -
                        @endif
                    @endif
                </td>
                <td class="small">{{ $d($rec->productionDeadline) }}</td>
                <td class="small">{{ $dt($rec->sendOrderToProductionStatus) }}</td>
                <td class="small">{{ $rec->productionStatus ?? '-' }}</td>
                <td class="small">{{ $rec->referenceNo ?? ($rec->sampleInquiry->referenceNo ?? '-') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="20" style="text-align:center; padding:12px;">No records found for selected filters.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Generated on {{ now()->format('Y-m-d H:i:s') }}
</div>

</body>
</html>

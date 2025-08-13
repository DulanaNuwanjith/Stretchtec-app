<!DOCTYPE html>
<html>
@php
use Carbon\Carbon;
@endphp

<head>
    <title>Sample Order Report - {{ $sampleInquiry->orderNo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        h1,
        h2 {
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            border: 1px solid #777;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 25px;
        }

        ul li {
            padding: 4px 0;
        }

        ul li strong {
            width: 250px;
            display: inline-block;
            color: #34495E;
        }

        .section {
            margin-bottom: 40px;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            color: #aaa;
            margin-top: 50px;
        }

        img {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            border: 1px solid #ccc;
            padding: 2px;
        }

        .product-catalog-images {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .product-catalog-images>div {
            max-width: 140px;
            text-align: center;
        }

        /* Grid container for main layout */
        .grid-container,
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px 50px;

            /* Spread columns horizontally */
            justify-content: space-between;

            /* Make full width */
            width: 100%;
            margin-top: 40px;
        }

        /* Nested grid for R&D + Yarn Order on right top */
        .right-top {
            display: grid;
            grid-template-rows: auto auto;
            gap: 25px;
        }

        /* Padding inside columns */
        .grid-container>div,
        .bottom-row>div {
            padding: 0 10px;
        }

        /* Full width container for product catalogs */
        .full-width {
            grid-column: 1 / -1;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <h1>Sample Order Report - {{ $sampleInquiry->orderNo }}</h1>

    <div class="grid-container">
        <!-- Left top: Sample Inquiry Details -->
        <div class="section">
            <h2>Sample Inquiry Details</h2>
            <div style="display: flex; align-items: flex-start; gap: 40px;">
                <!-- Left side: text details -->
                <ul style="list-style: none; padding-left: 0; margin: 0; flex: 1;">
                    <li><strong style="width: 180px; display: inline-block;">Inquiry Received Date:</strong>
                        {{ $sampleInquiry->inquiryReceiveDate->format('Y-m-d') }}</li>
                    <li><strong style="width: 180px; display: inline-block;">Customer:</strong>
                        {{ $sampleInquiry->customerName }}</li>
                    @if ($sampleInquiry->customerRequestDate)
                        <li><strong style="width: 180px; display: inline-block;">Customer Requested Date:</strong>
                            {{ $sampleInquiry->customerRequestDate->format('Y-m-d') }}</li>
                    @endif
                    <li><strong style="width: 180px; display: inline-block;">Customer Merchandiser Name:</strong>
                        {{ $sampleInquiry->merchandiseName ?? 'N/A' }}</li>
                    <li><strong style="width: 180px; display: inline-block;">Customer Coordinator Name:</strong>
                        {{ $sampleInquiry->coordinatorName ?? 'N/A' }}</li>
                    <li><strong style="width: 180px; display: inline-block;">Customer Delivery Date:</strong>
                        {{ $sampleInquiry->customerDeliveryDate->format('Y-m-d') ?? 'N/A' }}</li>
                    <li><strong style="width: 180px; display: inline-block;">Customer Decision:</strong>
                        {{ $customerDecision ?? 'N/A' }}</li>
                    @if ($sampleInquiry->inquiryReceiveDate && $sampleInquiry->customerDeliveryDate)
                        <li><strong style="width: 180px; display: inline-block;">Days to Delivery:</strong>
                            {{ Carbon::parse($sampleInquiry->inquiryReceiveDate)->diffInDays(Carbon::parse($sampleInquiry->customerDeliveryDate)) }}
                            days
                        </li>
                    @else
                        <li><strong style="width: 180px; display: inline-block;">Days to Delivery:</strong> N/A</li>
                    @endif
                </ul>

                <!-- Right side: order file image + download -->
                <div style="flex-shrink: 0; max-width: 250px;">
                    @if ($sampleInquiry->orderFile)
                        <img src="{{ public_path('storage/' . $sampleInquiry->orderFile) }}" alt="Order File Image"
                            style="max-width: 100%; max-height: 150px; border: 1px solid #ccc; padding: 2px;" />
                    @else
                        <p>No order file available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right top: R&D + Yarn Order stacked -->
        <div class="right-top">
            <div class="section">
                <h2>Research & Development (R&D) Details</h2>
                @if ($rnd)
                    <ul>
                        <li><strong>Development Plan Date:</strong>
                            {{ optional($rnd->developPlannedDate)->format('Y-m-d') ?? 'N/A' }}</li>
                        <li><strong>Colour Match Sent Date:</strong>
                            {{ optional($rnd->colourMatchSentDate)->format('Y-m-d H:i') ?? 'N/A' }}</li>
                        <li><strong>Colour Match Receive Date:</strong>
                            {{ optional($rnd->colourMatchReceiveDate)->format('Y-m-d H:i') ?? 'N/A' }}</li>
                        <li><strong>Yarn Ordered PO Number:</strong> {{ $rnd->yarnOrderedPONumber ?? 'N/A' }}</li>
                    </ul>
                @else
                    <p>No R&D data available for this order.</p>
                @endif
            </div>

            <div class="section">
                <h2>Yarn Order Details</h2>
                <ul>
                    <li><strong>Yarn Ordered Quantity (grams):</strong> {{ $yarnOrderedQuantity ?? 'N/A' }}</li>
                    <li><strong>Leftover Yarn Quantity (grams):</strong> {{ $leftoverYarnQuantity ?? 'N/A' }}</li>
                    <li><strong>Yarn Price:</strong> {{ $yarnPrice ? number_format($yarnPrice, 2) : 'N/A' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bottom row: Production (left) and Colour Match Reject (right) -->
    <div class="bottom-row">
        <div class="section">
            <h2>Production Details</h2>
            @if ($production)
                <ul>
                    <li><strong>Production Deadline:</strong>
                        {{ optional($production->production_deadline)->format('Y-m-d') ?? 'N/A' }}</li>
                    <li><strong>Order Received At:</strong>
                        {{ optional($production->order_received_at)->format('Y-m-d H:i') ?? 'N/A' }}</li>
                    <li><strong>Order Start At:</strong>
                        {{ optional($production->order_start_at)->format('Y-m-d H:i') ?? 'N/A' }}</li>
                    <li><strong>Order Complete At:</strong>
                        {{ optional($production->order_complete_at)->format('Y-m-d H:i') ?? 'N/A' }}</li>
                    <li><strong>Operator:</strong> {{ $production->operator_name ?? 'N/A' }}</li>
                    <li><strong>Supervisor:</strong> {{ $production->supervisor_name ?? 'N/A' }}</li>
                    <li><strong>Production Output (grams):</strong>
                        {{ $production->production_output ? number_format($production->production_output) : 'N/A' }}
                    </li>
                    <li><strong>Damaged Output (grams):</strong>
                        {{ $production->damaged_output ? number_format($production->damaged_output) : 'N/A' }}</li>
                    <li><strong>Dispatch To R&D At:</strong>
                        {{ optional($production->dispatch_to_rnd_at)->format('Y-m-d H:i') ?? 'N/A' }}</li>
                    <li><strong>Dispatched By:</strong> {{ $production->dispatched_by ?? 'N/A' }}</li>
                    <li><strong>Note:</strong> {{ $production->note ?? 'N/A' }}</li>
                </ul>
            @else
                <p>No production data available for this order.</p>
            @endif
        </div>

        <div class="section">
            <h2>Colour Match Reject Records</h2>
            @if ($colorRejects->isNotEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>Sent Date</th>
                            <th>Receive Date</th>
                            <th>Reject Date</th>
                            <th>Reject Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colorRejects as $reject)
                            <tr>
                                <td>{{ optional($reject->sentDate)->format('Y-m-d H:i') ?? 'N/A' }}</td>
                                <td>{{ optional($reject->receiveDate)->format('Y-m-d H:i') ?? 'N/A' }}</td>
                                <td>{{ optional($reject->rejectDate)->format('Y-m-d H:i') ?? 'N/A' }}</td>
                                <td>{{ $reject->rejectReason }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No colour match reject records found.</p>
            @endif
        </div>
    </div>

    <!-- Full width Product Catalog Images -->
    @if (isset($productCatalogs) && $productCatalogs->isNotEmpty())
        <div class="section full-width">
            <h2>Product Catalog Images</h2>
            @foreach ($productCatalogs as $product)
                <div style="margin-bottom: 15px;">
                    <strong>Order No:</strong> {{ $product->order_no }} <br />
                    <strong>Reference No:</strong> {{ $product->reference_no }} <br />
                    <div class="product-catalog-images">
                        @if ($product->order_image)
                            <div>
                                <strong>Product Image:</strong><br />
                                <img src="{{ public_path('storage/order_images/' . $product->order_image) }}"
                                    alt="Order Image" />
                            </div>
                        @endif

                        @if ($product->approval_card)
                            <div>
                                <strong>Approval Card:</strong><br />
                                <img src="{{ public_path('storage/' . $product->approval_card) }}"
                                    alt="Approval Card" />
                            </div>
                        @endif

                        <div>
                            <strong>Approved By:</strong> {{ $product->approved_by ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="footer">
        Report generated on {{ now()->format('Y-m-d H:i:s') }}
    </div>

</body>

</html>

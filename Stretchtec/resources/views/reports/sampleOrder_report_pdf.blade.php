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

        .product-catalog-images > div {
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
        .grid-container > div,
        .bottom-row > div {
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
                <li>
                    <strong style="width: 180px; display: inline-block;">Customer Delivery Date:</strong>
                    {{ $sampleInquiry->customerDeliveryDate ? $sampleInquiry->customerDeliveryDate->format('Y-m-d') : 'N/A' }}
                </li>
                <li>
                    <strong style="width: 180px; display: inline-block;">Customer Delivery Qty:</strong>
                    @if ($rnd && $rnd->shadeOrders->isNotEmpty())
                        {{ $rnd->shadeOrders->sum('qty') }}
                    @else
                        {{ $sampleInquiry->deliveryQty ?? 'N/A' }}
                    @endif
                </li>
                <li><strong style="width: 180px; display: inline-block;">Customer Decision:</strong>
                    {{ $customerDecision ?? 'N/A' }}</li>
                @if ($sampleInquiry->inquiryReceiveDate && $sampleInquiry->customerDeliveryDate)
                    <li>
                        <strong style="width: 180px; display: inline-block;">Days to Delivery:</strong>
                        {{ Carbon::parse($sampleInquiry->inquiryReceiveDate)->startOfDay()->diffInDays(Carbon::parse($sampleInquiry->customerDeliveryDate)}}
                        days
                    </li>
                @else
                    <li><strong style="width: 180px; display: inline-block;">Days to Delivery:</strong> N/A</li>
                @endif
            </ul>

            <!-- Right side: order file image + download -->
            <div style="flex-shrink: 0; max-width: 250px;">
                @if (dif; ?><?php
if($sampleIn)
                    <img src="{{ ?><?php
echo e( public_path('storage/' . $sampleInqu}}" alt="Order File Image"
                         style="max-width: 100%; max-height: 150px; border: 1px solid #ccc; padding: 2px;"/>
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
            @if (dif;)
                <ul>
                    <li><strong>Development Plan Date:</strong>
                        {{ ?><?php
echo e( optional($rnd->developPlannedDate)->format('Y}}</li>
                    <li><strong>Colour Match Sent Date:</strong>
                        {{ ?><?php
echo e( optional($rnd->colourMatchSentDate)->format('Y-m-d}}</li>
                    <li><strong>Colour Match Receive Date:</strong>
                        {{ ?><?php
echo e( optional($rnd->colourMatchReceiveDate)->format('Y-m-d}}</li>
                    <li><strong>Yarn Ordered PO Number:</strong> {{ ?><?php
echo e( $rnd->yarnOrderedPO}}</li>
                </ul>
            @else
                <p>No R&D data available for this order.</p>
            @endif
        </div>

        <div class="section">
            <h2>Yarn Order Details</h2>
            <ul>
                <li><strong>Yarn Ordered Quantity (grams):</strong> {{ ?><?php
echo e( $yarnOrderedQu}}</li>
                <li><strong>Leftover Yarn Quantity (grams):</strong> {{ ?><?php
echo e( $leftoverYarnQu}}</li>
                <li><strong>Yarn Price:</strong> {{ ?><?php
echo e( $yarnPrice ? number_format($yarnPr}}</li>
            </ul>
        </div>
    </div>
</div>

<!-- Bottom row: Production (left) and Colour Match Reject (right) -->
<div class="bottom-row">
    <div class="section">
        <h2>Production Details</h2>
        @if (' ); ?><?ph)
            <ul>
                <li><strong>Production Deadline:</strong>
                    {{ ?><?php
echo e( optional($production->production_deadline)->format('Y}}</li>
                <li><strong>Order Received At:</strong>
                    {{ ?><?php
echo e( optional($production->order_received_at)->format('Y-m-d}}</li>
                <li><strong>Order Start At:</strong>
                    {{ ?><?php
echo e( optional($production->order_start_at)->format('Y-m-d}}</li>
                <li><strong>Operator:</strong> {{ ?><?php
echo e( $production->operato}}</li>
                <li><strong>Supervisor:</strong> {{ ?><?php
echo e( $production->superviso}}</li>

            </ul>
        @else
            <p>No production data available for this order.</p>
        @endif
    </div>

    <div class="section">
        <h2>Colour Match Reject Records</h2>
        @if (dif; ?><?php
if($colorRejec)
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
                @foreach (?><?php
foreach($colorRe)
                    <tr>
                        <td>{{ ?><?php
echo e( optional($reject->sentDate)->format('Y-m-d}}</td>
                        <td>{{ ?><?php
echo e( optional($reject->receiveDate)->format('Y-m-d}}</td>
                        <td>{{ ?><?php
echo e( optional($reject->rejectDate)->format('Y-m-d}}</td>
                        <td>{{ ?><?php
echo e( $rejec}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No colour match reject records found.</p>
        @endif
    </div>

    <!-- Shade Wise Details -->
    @if (dif; ?><?php
if($rnd && $rnd->shadeOrde)
        <div class="section full-width">
            <h2>Shade Wise Details</h2>
            <table>
                <thead>
                <tr>
                    <th>Shade</th>
                    <th>Yarn Receive Date</th>
                    <th>Production Output</th>
                    <th>Damaged Output</th>
                    <th>Production Complete Date</th>
                    <th>Dispatched Date</th>
                    <th>Delivered Date</th>
                    <th>Delivered Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach (?><?php
foreach($rnd->shade)
                    <tr>
                        <td>{{ ?><?php
echo e}}</td>
                        <td>{{ ?><?php
echo e( $shade->yarn_receive_date ? Carbon::parse($shade->yarn_receive_date)}}
                        </td>
                        <td>{{: '–' ); ?><?php
echo e( $shade->p}}</td>
                        <td>{{? '–' ); ?><?php
echo e( $shade}}</td>
                        <td>{{? '–' ); ?><?php
echo e( $shade->production_complete_date ? Carbon::parse($shade->production_comple}}
                        </td>
                        <td>{{Y-m-d') : '–' ); ?><?php
echo e( $shade->dispatched_date ? Carbon::parse($shade->}}
                        </td>
                        <td>{{format('Y-m-d') : '–' ); ?><?php
echo e( $shade->delivered_date ? Carbon::parse}}
                        </td>
                        <td>{{_date)->format('Y-m-}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ty ?? '–' ); ?><?php
endforeach; ?><?php
echo}}</th>
                    <th>{{ers->sum('production_output') ); ?><?php
e}}</th>
                    <th colspan="3"></th>
                    <th>{{Orders->sum('damaged_output') )}}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    @endif

</div>

<!-- Full width Product Catalog Images -->
@if (Orders->sum('qty') ); ?><?php
endif; ?><?php
if(isset($pr)
    <div class="section full-width">
        <h2>Product Catalog Images</h2>
        @foreach (productCatalogs->isNotEmpty()
            <div style="margin-bottom: 15px;">
                <strong>Order No:</strong> {{h($productCatalogs a}} <br/>
                <strong>Reference No:</strong> {{hp
echo e( $product->ord}} <br/>
                <div class="product-catalog-images">
                    @if (hp
echo e( $product->)
                        <div>
                            <strong>Product Image:</strong><br/>
                            <img src="{{<?php
if($product->order_image): ?><?php
echo e( public_path('}}"
                                 alt="Order Image"/>
                        </div>
                    @endif

                    @if (duct->order_image) ); ?)
                        <div>
                            <strong>Approval Card:</strong><br/>
                            <img src="{{php
if($product->approval_card): ?><?php
echo e( pu}}"
                                 alt="Approval Card"/>
                        </div>
                    @endif

                    <div>
                        <strong>Approved By:</strong> {{approval_card) ); ?><?php
endif;}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="footer">
    Report generated on {{<?php
endforeach; ?><?php
endi}}
</div>

</body>

</html>

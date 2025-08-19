<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationRnD;
use App\Models\SamplePreparationProduction;
use App\Models\ColorMatchReject;
use App\Models\ProductCatalog;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Show report filter page with customers dropdown
    public function showReportPage()
    {
        $customers = SampleInquiry::select('customerName')
            ->distinct()
            ->orderBy('customerName')
            ->pluck('customerName');

        return view('reports.sample-reports', compact('customers'));
    }

    // Generate PDF report filtered by date range and optional customer
    public function inquiryCustomerDecisionReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'customer'   => 'nullable|string',
        ]);

        $query = SampleInquiry::whereBetween('inquiryReceiveDate', [$request->start_date, $request->end_date])
                            ->whereNotNull('customerDeliveryDate'); // Only those with delivery date

        if ($request->filled('customer')) {
            $query->where('customerName', $request->customer);
        }

        $inquiries = $query->select('orderNo', 'customerName', 'customerDecision', 'inquiryReceiveDate', 'customerDeliveryDate')->get();

        $pdf = PDF::loadView('reports.inquiry-customer-decision-pdf', [
            'inquiries'  => $inquiries,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'customer'   => $request->customer,
        ]);

        return $pdf->download("Inquiry_Customer_Decision_Report_{$request->start_date}_to_{$request->end_date}.pdf");
    }

    public function generateOrderReport(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string|exists:sample_inquiries,orderNo',
        ]);

        $orderNo = $request->order_no;

        $sampleInquiry = SampleInquiry::where('orderNo', $orderNo)->first();

        $rnd = SamplePreparationRnD::where('orderNo', $orderNo)->first();

        $production = SamplePreparationProduction::where('order_no', $orderNo)->first();

        $colorRejects = ColorMatchReject::where('orderNo', $orderNo)
            ->orderBy('rejectDate', 'desc')
            ->get();

        $productCatalogs = ProductCatalog::where('order_no', $orderNo)->get();

        $customerDecision = $sampleInquiry->customerDecision ?? null;

        $yarnOrderedQuantity = $rnd->yarnOrderedWeight ?? null;
        $leftoverYarnQuantity = $rnd->yarnLeftoverWeight ?? null;
        $yarnPrice = $rnd->yarnPrice ?? null;

        // Calculate days difference if both dates exist
        $daysToDelivery = null;

        if ($sampleInquiry->inquiryReceiveDate && $sampleInquiry->customerDeliveryDate) {
            $start = Carbon::parse($sampleInquiry->inquiryReceiveDate)->startOfDay();
            $end   = Carbon::parse($sampleInquiry->customerDeliveryDate)->startOfDay();

            $daysToDelivery = $start->diffInDays($end); // Always integer
        }


        $reportData = [
            'sampleInquiry'        => $sampleInquiry,
            'rnd'                  => $rnd,
            'production'           => $production,
            'colorRejects'         => $colorRejects,
            'productCatalogs'      => $productCatalogs,  // Pass it here!
            'customerDecision'     => $customerDecision,
            'yarnOrderedQuantity'  => $yarnOrderedQuantity,
            'leftoverYarnQuantity' => $leftoverYarnQuantity,
            'yarnPrice'            => $yarnPrice,
            'daysToDelivery'       => $daysToDelivery,
        ];

        $pdf = PDF::loadView('reports.sampleOrder_report_pdf', $reportData);

        return $pdf->download("Order_Report_{$orderNo}.pdf");
    }

    public function inquiryRangeReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        $inquiries = SampleInquiry::whereBetween('inquiryReceiveDate', [
                $request->start_date,
                $request->end_date
            ])
            ->select('orderNo', 'customerName', 'coordinatorName', 'customerDecision', 'customerDeliveryDate')
            ->get();

        // Not delivered = customerDeliveryDate is NULL
        $notDelivered = $inquiries->whereNull('customerDeliveryDate');

        // Delivered = customerDeliveryDate is NOT NULL
        $needToDeliver = $inquiries->whereNotNull('customerDeliveryDate');

        $pdf = \PDF::loadView('reports.inquiry-range-pdf', [
            'notDelivered' => $notDelivered,
            'needToDeliver' => $needToDeliver,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $pdf->download("Inquiry_Report_{$request->start_date}_to_{$request->end_date}.pdf");
    }

    public function yarnSupplierSpendingReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $suppliers = SamplePreparationRnD::whereBetween('yarnOrderedDate', [$request->start_date, $request->end_date])
            ->selectRaw('yarnSupplier, SUM(yarnPrice) as total_spent, SUM(yarnOrderedWeight) as total_weight')
            ->groupBy('yarnSupplier')
            ->orderBy('total_spent', 'desc')
            ->get();

        $pdf = \PDF::loadView('reports.yarn-supplier-spending-pdf', [
            'suppliers'  => $suppliers,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
        ]);

        return $pdf->download("Yarn_Supplier_Spending_{$request->start_date}_to_{$request->end_date}.pdf");
    }

    public function coordinatorReportPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $coordinators = SampleInquiry::query()
            ->whereBetween('inquiryReceiveDate', [$startDate, $endDate])
            ->select(
                'coordinatorName',
                'orderNo',
                'inquiryReceiveDate',
                'customerName',
                'customerDeliveryDate',
                'customerDecision'
            )
            ->orderBy('coordinatorName')
            ->get()
            ->groupBy('coordinatorName');

        $report = [];

        foreach ($coordinators as $coordinator => $orders) {
            // Format inquiryReceiveDate to only show date
            $orders->transform(function ($order) {
                $order->inquiryReceiveDate = Carbon::parse($order->inquiryReceiveDate)->format('Y-m-d');
                if ($order->customerDeliveryDate) {
                    $order->customerDeliveryDate = Carbon::parse($order->customerDeliveryDate)->format('Y-m-d');
                }
                return $order;
            });

            $report[$coordinator] = [
                'orders' => $orders,
                'total_orders' => $orders->count(),
                'rejected_count' => $orders->where('customerDecision', 'Order Rejected')->count(),
                'received_count' => $orders->where('customerDecision', 'Order Received')->count(),
                'not_received_count' => $orders->where('customerDecision', 'Order Not Received')->count(),
                'pending_count' => $orders->where('customerDecision', 'Pending')->count(),
            ];
        }

        $pdf = Pdf::loadView('reports.coordinator_report_pdf', compact('report', 'startDate', 'endDate'));

        return $pdf->download("Coordinator_Report_{$startDate}_to_{$endDate}.pdf");
    }

    public function referenceDeliveryReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        $inquiries = SampleInquiry::whereBetween('inquiryReceiveDate', [$startDate, $endDate])
            ->whereNotNull('customerDeliveryDate') // ✅ Only after delivery
            ->select('referenceNo', 'inquiryReceiveDate', 'customerName', 'customerDeliveryDate', 'deliveryQty')
            ->orderBy('inquiryReceiveDate')
            ->get()
            ->map(function ($inquiry) {
                $inquiry->inquiryReceiveDate = $inquiry->inquiryReceiveDate
                    ? \Carbon\Carbon::parse($inquiry->inquiryReceiveDate)->format('Y-m-d')
                    : null;
                $inquiry->customerDeliveryDate = $inquiry->customerDeliveryDate
                    ? \Carbon\Carbon::parse($inquiry->customerDeliveryDate)->format('Y-m-d')
                    : null;
                $inquiry->deliveryQty = $inquiry->deliveryQty ?? '-';
                return $inquiry;
            });

        $pdf = \PDF::loadView('reports.reference_delivery_report_pdf', compact('inquiries', 'startDate', 'endDate'));

        return $pdf->download("Reference_Delivery_Report_{$startDate}_to_{$endDate}.pdf");
    }

    public function generateSampleInquiryReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'coordinatorName' => 'required|array',
        ]);

        $inquiries = SampleInquiry::with('samplePreparationRnD')
            ->whereBetween('inquiryReceiveDate', [$request->start_date, $request->end_date])
            ->whereIn('coordinatorName', $request->coordinatorName)
            ->get();

        // Generate PDF in landscape orientation
        $pdf = Pdf::loadView('reports.sample_inquiry_report_pdf', [
            'inquiries'   => $inquiries,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'coordinators'=> $request->coordinatorName,
        ])->setPaper('legal', 'landscape'); // <--- set landscape

        return $pdf->download("Sample_Inquiry_Report_{$request->start_date}_to_{$request->end_date}.pdf");
    }
}

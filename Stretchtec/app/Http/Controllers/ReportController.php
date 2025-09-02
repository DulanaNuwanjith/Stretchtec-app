<?php

namespace App\Http\Controllers;

use App\Models\ColorMatchReject;
use App\Models\ProductCatalog;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationProduction;
use App\Models\SamplePreparationRnD;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the report generation page with customer list.
     */
    public function showReportPage()
    {
        $customers = SampleInquiry::select('customerName')
            ->distinct()
            ->orderBy('customerName')
            ->pluck('customerName');

        // Get all distinct reject numbers from SampleInquiry
        $rejectNumbers = SampleInquiry::select('rejectNO')
            ->distinct()
            ->whereNotNull('rejectNO')
            ->orderBy('rejectNO')
            ->pluck('rejectNO');

        return view('reports.sample-reports', compact('customers', 'rejectNumbers'));
    }


    /**
     * Generate inquiry report filtered by customer decision and date range
     */
    public function inquiryCustomerDecisionReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer' => 'nullable|string',
        ]);

        $query = SampleInquiry::whereBetween('inquiryReceiveDate', [$request->start_date, $request->end_date])
            ->whereNotNull('customerDeliveryDate'); // Only those with delivery date

        if ($request->filled('customer')) {
            $query->where('customerName', $request->customer);
        }

        $inquiries = $query->select('orderNo', 'customerName', 'customerDecision', 'inquiryReceiveDate', 'customerDeliveryDate')->get();

        $pdf = PDF::loadView('reports.inquiry-customer-decision-pdf', [
            'inquiries' => $inquiries,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'customer' => $request->customer,
        ]);

        return $pdf->download("Inquiry_Customer_Decision_Report_{$request->start_date}_to_{$request->end_date}.pdf");
    }


    /**
     * Generate detailed order report by order number
     */
    public function generateOrderReport(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string|exists:sample_inquiries,orderNo',
        ]);

        $orderNo = $request->order_no;

        $sampleInquiry = SampleInquiry::where('orderNo', $orderNo)->first();

        $rnd = SamplePreparationRnD::where('orderNo', $orderNo)
            ->with('shadeOrders')
            ->first();

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
            $end = Carbon::parse($sampleInquiry->customerDeliveryDate)->startOfDay();

            $daysToDelivery = $start->diffInDays($end); // Always integer
        }


        $reportData = [
            'sampleInquiry' => $sampleInquiry,
            'rnd' => $rnd,
            'production' => $production,
            'colorRejects' => $colorRejects,
            'productCatalogs' => $productCatalogs,  // Pass it here!
            'customerDecision' => $customerDecision,
            'yarnOrderedQuantity' => $yarnOrderedQuantity,
            'leftoverYarnQuantity' => $leftoverYarnQuantity,
            'yarnPrice' => $yarnPrice,
            'daysToDelivery' => $daysToDelivery,
        ];

        $pdf = PDF::loadView('reports.sampleOrder_report_pdf', $reportData);

        return $pdf->download("Order_Report_{$orderNo}.pdf");
    }


    /**
     * Generate inquiry report filtered by date range
     */
    public function inquiryRangeReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
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

        $pdf = PDF::loadView('reports.inquiry-range-pdf', [
            'notDelivered' => $notDelivered,
            'needToDeliver' => $needToDeliver,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $pdf->download("Inquiry_Report_{$request->start_date}_to_{$request->end_date}.pdf");
    }


    /**
     * Generate yarn supplier spending report filtered by date range
     */
    public function yarnSupplierSpendingReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $suppliers = SamplePreparationRnD::whereBetween('yarnOrderedDate', [$request->start_date, $request->end_date])
            ->selectRaw('yarnSupplier, SUM(yarnPrice) as total_spent, SUM(yarnOrderedWeight) as total_weight')
            ->groupBy('yarnSupplier')
            ->orderBy('total_spent', 'desc')
            ->get();

        $pdf = PDF::loadView('reports.yarn-supplier-spending-pdf', [
            'suppliers' => $suppliers,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $pdf->download("Yarn_Supplier_Spending_{$request->start_date}_to_{$request->end_date}.pdf");
    }


    /**
     * Generate coordinator performance report filtered by date range
     */
    public function coordinatorReportPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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


    /**
     * Generate coordinator performance report filtered by date range
     */
    public function referenceDeliveryReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $inquiries = SampleInquiry::whereBetween('inquiryReceiveDate', [$startDate, $endDate])
            ->whereNotNull('customerDeliveryDate') // ✅ Only after delivery
            ->select('referenceNo', 'inquiryReceiveDate', 'customerName', 'customerDeliveryDate', 'deliveryQty')
            ->orderBy('inquiryReceiveDate')
            ->get()
            ->map(function ($inquiry) {
                $inquiry->inquiryReceiveDate = $inquiry->inquiryReceiveDate
                    ? Carbon::parse($inquiry->inquiryReceiveDate)->format('Y-m-d')
                    : null;
                $inquiry->customerDeliveryDate = $inquiry->customerDeliveryDate
                    ? Carbon::parse($inquiry->customerDeliveryDate)->format('Y-m-d')
                    : null;
                $inquiry->deliveryQty = $inquiry->deliveryQty ?? '-';
                return $inquiry;
            });

        $pdf = PDF::loadView('reports.reference_delivery_report_pdf', compact('inquiries', 'startDate', 'endDate'));

        return $pdf->download("Reference_Delivery_Report_{$startDate}_to_{$endDate}.pdf");
    }


    /**
     * Generate sample inquiry report filtered by date range and coordinators
     */
    public function generateSampleInquiryReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'coordinatorName' => 'required|array',
        ]);

        $inquiries = SampleInquiry::with('samplePreparationRnD')
            ->whereBetween('inquiryReceiveDate', [$request->start_date, $request->end_date])
            ->whereIn('coordinatorName', $request->coordinatorName)
            ->orderBy('id', 'desc')
            ->get();

        // Generate PDF in landscape orientation
        $pdf = Pdf::loadView('reports.sample_inquiry_report_pdf', [
            'inquiries' => $inquiries,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'coordinators' => $request->coordinatorName,
        ])->setPaper('legal', 'landscape'); // <--- set landscape

        return $pdf->download("Sample_Inquiry_Report_{$request->start_date}_to_{$request->end_date}.pdf");
    }

    public function generateRejectReportPdf(Request $request)
    {
        $request->validate([
            'reject_no' => 'required|string',
        ]);

        $rejectNo = $request->reject_no;

        // Get all SampleInquiry records with rejectNO = $rejectNo
        $inquiries = SampleInquiry::whereNotNull('rejectNO')
            ->where('rejectNO', $rejectNo)
            ->with('samplePreparationRnD')
            ->get();

        // Get unique customer names and coordinator names (in case there are multiple)
        $customerNames = $inquiries->pluck('customerName')->unique()->join(', ');
        $coordinatorNames = $inquiries->pluck('coordinatorName')->unique()->join(', ');

        // Group by orderNo
        $orders = $inquiries->groupBy('orderNo')->map(function ($items, $orderNo) {
            $totalYarnPrice = $items->sum(function ($inquiry) {
                return $inquiry->samplePreparationRnD->yarnPrice ?? 0;
            });

            $rejectCount = $items->count();

            // Collect all customerDecision values for this order
            $customerDecisions = $items->pluck('customerDecision')->unique()->join(', ');

            return [
                'reject_count' => $rejectCount,
                'total_yarn_price' => $totalYarnPrice,
                'orderNos' => $orderNo,
                'customerDecision' => $customerDecisions,
            ];
        });

        $pdf = PDF::loadView('reports.reject_report_pdf', [
            'orders' => $orders,
            'rejectNo' => $rejectNo,
            'customerNames' => $customerNames,
            'coordinatorNames' => $coordinatorNames,
        ])->setPaper('A4', 'portrait');

        return $pdf->download("Reject_Report_{$rejectNo}.pdf");
    }

    public function generateCustomerRejectReportPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer_name' => 'nullable|string', // not required anymore
        ]);

        $start = $request->start_date;
        $end = $request->end_date;
        $customer = $request->customer_name;

        // Build query
        $query = SampleInquiry::whereBetween('inquiryReceiveDate', [$start, $end])
            ->whereNotNull('rejectNO')
            ->with('samplePreparationRnD');

        // Apply customer filter only if selected
        if (!empty($customer)) {
            $query->where('customerName', $customer);
        }

        $inquiries = $query->get();

        // Group by rejectNO
        $rejectGroups = $inquiries->groupBy('rejectNO')->map(function ($items, $rejectNo) {
            $orders = $items->groupBy('orderNo')->map(function ($orderItems, $orderNo) {
                $totalYarnPrice = $orderItems->sum(fn($i) => $i->samplePreparationRnD->yarnPrice ?? 0);
                $customerDecisions = $orderItems->pluck('customerDecision')->unique()->join(', ');

                return [
                    'orderNo' => $orderNo,
                    'customerDecision' => $customerDecisions,
                    'total_yarn_price' => $totalYarnPrice,
                ];
            });

            return [
                'orders' => $orders,
                'total_orders' => $orders->count(),
                'total_rejections' => $orders->filter(fn($o) => str_contains($o['customerDecision'], 'Order Rejected'))->count(),
                'total_yarn_price' => $orders->sum('total_yarn_price'),
            ];
        });

        // Prepare PDF
        $pdf = PDF::loadView('reports.customer_reject_report_pdf', [
            'rejectGroups' => $rejectGroups,
            'customerName' => $customer ?: 'All Customers',
            'start_date' => $start,
            'end_date' => $end,
        ])->setPaper('A4', 'portrait');

        // Build filename safely
        $fileNameCustomer = $customer ?: 'All_Customers';
        $fileName = "Customer_Reject_Report_{$fileNameCustomer}_{$start}_to_{$end}.pdf";

        return $pdf->download($fileName);
    }


}

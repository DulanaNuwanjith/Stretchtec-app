<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationRnD;
use App\Models\SamplePreparationProduction;
use App\Models\ColorMatchReject;
use App\Models\ProductCatalog;
use PDF;

class ReportController extends Controller
{
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
        ];

        $pdf = PDF::loadView('reports.sampleOrder_report_pdf', $reportData);

        return $pdf->download("Order_Report_{$orderNo}.pdf");
    }
}

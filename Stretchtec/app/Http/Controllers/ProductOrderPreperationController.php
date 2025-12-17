<?php

namespace App\Http\Controllers;

use App\Models\AssignedRawMaterial;
use App\Models\AssignedRawMaterialExport;
use App\Models\ExportRawMaterial;
use App\Models\ProductOrderPreperation;
use App\Models\RawMaterialStore;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductOrderPreperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Factory|View
    {
        $query = ProductOrderPreperation::query()->latest();

        // Apply filters
        if ($request->filled('orderNo')) {
            $query->where('prod_order_no', $request->input('orderNo'));
        }
        if ($request->filled('customer')) {
            $query->where('customer_name', $request->input('customer'));
        }
        if ($request->filled('referenceNo')) {
            $query->where('reference_no', $request->input('referenceNo'));
        }
        if ($request->filled('shade')) {
            $query->where('shade', $request->input('shade'));
        }
        if ($request->filled('tkt')) {
            $query->where('tkt', $request->input('tkt'));
        }
        if ($request->filled('supplier')) {
            $query->where('supplier', $request->input('supplier'));
        }

        $orderPreparations = $query->paginate(10)->appends($request->query());

        $localRawMaterials = RawMaterialStore::orderBy('available_quantity', 'desc')->get();
        $exportRawMaterials = ExportRawMaterial::orderBy('net_weight', 'desc')->get();

        // Get the assigned raw materials with their related details
        $assignedLocalRawMaterials = AssignedRawMaterial::with('rawMaterial')->latest()->get();
        $assignedExportRawMaterials = AssignedRawMaterialExport::with('exportRawMaterial')->latest()->get();

        // Dropdown option lists
        $orderNos = ProductOrderPreperation::select('prod_order_no')
            ->whereNotNull('prod_order_no')
            ->distinct()
            ->orderBy('prod_order_no')
            ->pluck('prod_order_no');

        $customers = ProductOrderPreperation::select('customer_name')
            ->whereNotNull('customer_name')
            ->distinct()
            ->orderBy('customer_name')
            ->pluck('customer_name');

        $referenceNumbers = ProductOrderPreperation::select('reference_no')
            ->whereNotNull('reference_no')
            ->distinct()
            ->orderBy('reference_no')
            ->pluck('reference_no');

        $shades = ProductOrderPreperation::select('shade')
            ->whereNotNull('shade')
            ->distinct()
            ->orderBy('shade')
            ->pluck('shade');

        $tkts = ProductOrderPreperation::select('tkt')
            ->whereNotNull('tkt')
            ->distinct()
            ->orderBy('tkt')
            ->pluck('tkt');

        $suppliers = ProductOrderPreperation::select('supplier')
            ->whereNotNull('supplier')
            ->distinct()
            ->orderBy('supplier')
            ->pluck('supplier');

        return view(
            'production.pages.production-order-preparation',
            compact(
                'orderPreparations',
                'localRawMaterials',
                'exportRawMaterials',
                'assignedLocalRawMaterials',
                'assignedExportRawMaterials',
                'orderNos',
                'customers',
                'referenceNumbers',
                'shades',
                'tkts',
                'suppliers'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductOrderPreperation $productOrderPreperation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductOrderPreperation $productOrderPreperation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductOrderPreperation $productOrderPreperation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductOrderPreperation $productOrderPreperation)
    {
        //
    }

    public function markOrdered($id): RedirectResponse
    {
        $order = ProductOrderPreperation::findOrFail($id);

        $order->isRawMaterialOrdered = true;
        $order->raw_material_ordered_date = now(); // sets current date and time
        $order->status = 'Yarn Ordered';

        $order->save();

        return back()->with('success', 'Marked as ordered with timestamp.');
    }

    public function markReceived($id): RedirectResponse
    {
        $order = ProductOrderPreperation::findOrFail($id);

        $order->isRawMaterialReceived = true;
        $order->raw_material_received_date = now(); // sets current date and time
        $order->status = 'Yarn Received';

        $order->save();

        return back()->with('success', 'Marked as received with timestamp.');
    }

    public function setDeadline(Request $request, $orderId): RedirectResponse
    {
        // Validate only the fields coming from the form
        $request->validate([
            'production_deadline' => 'required|date',
            'deadline_reason' => 'required|string|max:255',
        ]);

        // Fetch the order
        $preperationOrder = ProductOrderPreperation::findOrFail($orderId);

        $inquiryOrder = $preperationOrder->source_order;

        if ($inquiryOrder) {
            // Update fields
            $inquiryOrder->production_deadline = $request->production_deadline;
            $inquiryOrder->deadline_reason = $request->deadline_reason;
            $inquiryOrder->save();
        }

        return redirect()->back()->with('success', 'Production deadline updated successfully.');
    }


}

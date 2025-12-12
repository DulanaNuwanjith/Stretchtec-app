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
    public function index(): Factory|View
    {
        $orderPreparations = ProductOrderPreperation::latest()->paginate(10);

        $localRawMaterials = RawMaterialStore::orderBy('available_quantity', 'desc')->get();
        $exportRawMaterials = ExportRawMaterial::orderBy('net_weight', 'desc')->get();

        // Get the assigned raw materials with their related details
        $assignedLocalRawMaterials = AssignedRawMaterial::with('rawMaterial')->latest()->get();
        $assignedExportRawMaterials = AssignedRawMaterialExport::with('exportRawMaterial')->latest()->get();

        return view(
            'production.pages.production-order-preparation',
            compact('orderPreparations', 'localRawMaterials', 'exportRawMaterials', 'assignedLocalRawMaterials', 'assignedExportRawMaterials')
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

        $inquiryOrder = $preperationOrder->inquiry;

        // Update fields
        $inquiryOrder->production_deadline = $request->production_deadline;
        $inquiryOrder->deadline_reason = $request->deadline_reason;
        $inquiryOrder->save();

        return redirect()->back()->with('success', 'Production deadline updated successfully.');
    }


}

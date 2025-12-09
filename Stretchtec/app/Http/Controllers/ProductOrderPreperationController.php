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
        // Fetch all records with pagination (adjust number per page as needed)
        $orderPreparations = ProductOrderPreperation::latest()->paginate(10);

        $localRawMaterials = RawMaterialStore::orderBy('available_quantity', 'desc')->get();

        $exportRawMaterials = ExportRawMaterial::orderBy('net_weight', 'desc')->get();

        //Get the assigned raw materials
        $assignedLocalRawMaterials = AssignedRawMaterial::latest()->get();
        $assignedExportRawMaterials = AssignedRawMaterialExport::latest()->get();

        // Pass data to the blade
        return view('production.pages.production-order-preparation', compact('orderPreparations', 'localRawMaterials', 'exportRawMaterials', 'assignedLocalRawMaterials', 'assignedExportRawMaterials'));
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

        $order->save();

        return back()->with('success', 'Marked as ordered with timestamp.');
    }

    public function markReceived($id): RedirectResponse
    {
        $order = ProductOrderPreperation::findOrFail($id);

        $order->isRawMaterialReceived = true;
        $order->raw_material_received_date = now(); // sets current date and time

        $order->save();

        return back()->with('success', 'Marked as received with timestamp.');
    }

}

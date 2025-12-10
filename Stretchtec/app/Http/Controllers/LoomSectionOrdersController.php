<?php

namespace App\Http\Controllers;

use App\Models\AssignedRawMaterial;
use App\Models\AssignedRawMaterialExport;
use App\Models\LoomSectionOrders;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LoomSectionOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $orders = LoomSectionOrders::latest()
            ->with('productInquiry', 'orderPreparation')
            ->get();

        // Group assigned items by order_preparation_id
        $localRawMaterial = AssignedRawMaterial::with('orderPreparation', 'rawMaterial')
            ->get()
            ->groupBy('order_preperation_id');

        $exportRawMaterial = AssignedRawMaterialExport::with('orderPreparation', 'exportRawMaterial')
            ->get()
            ->groupBy('order_preperation_id');

        return view('production.pages.loom', compact('orders', 'localRawMaterial', 'exportRawMaterial'));
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
    public function show(LoomSectionOrders $loomSectionOrders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoomSectionOrders $loomSectionOrders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoomSectionOrders $loomSectionOrders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoomSectionOrders $loomSectionOrders)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AssignedRawMaterial;
use App\Models\AssignedRawMaterialExport;
use App\Models\KnittedSectionOrders;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KnittedSectionOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $orders = KnittedSectionOrders::latest()
            ->with('productInquiry', 'mailBooking', 'orderPreparation')
            ->get();

        // Group assigned items by order_preparation_id
        $localRawMaterial = AssignedRawMaterial::with('orderPreparation', 'rawMaterial')
            ->get()
            ->groupBy('order_preperation_id');

        $exportRawMaterial = AssignedRawMaterialExport::with('orderPreparation', 'exportRawMaterial')
            ->get()
            ->groupBy('order_preperation_id');

        return view('production.pages.knitted', compact('orders', 'localRawMaterial', 'exportRawMaterial'));
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
    public function show(KnittedSectionOrders $knittedSectionOrders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnittedSectionOrders $knittedSectionOrders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KnittedSectionOrders $knittedSectionOrders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KnittedSectionOrders $knittedSectionOrders)
    {
        //
    }
}

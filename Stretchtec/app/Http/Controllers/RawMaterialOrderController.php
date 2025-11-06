<?php

namespace App\Http\Controllers;

use App\Models\RawMaterialOrder;
use Illuminate\Http\Request;

class RawMaterialOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = RawMaterialOrder::latest()->paginate(10);
        return view('store-management.pages.orderRawMaterial', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_no' => 'required|unique:raw_material_orders,order_no',
            'color' => 'required|string|max:255',
            'shade' => 'nullable|string|max:255',
            'pst_no' => 'nullable|string|max:255',
            'tkt' => 'nullable|string|max:255',
            'supplier_comment' => 'nullable|string|max:255',
            'qty' => 'required|integer|min:1',
            'kg_or_cone' => 'required|in:kg,cone',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        RawMaterialOrder::create($validated);

        return redirect()->route('orderRawMaterial.index')->with('success', 'Raw material order created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawMaterialOrder $orderRawMaterial)
    {
        $orderRawMaterial->delete();

        return redirect()->route('orderRawMaterial.index')->with('success', 'Order deleted successfully!');
    }
}

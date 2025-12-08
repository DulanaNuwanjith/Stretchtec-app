<?php

namespace App\Http\Controllers;

use App\Models\AssignedRawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use JsonException;

class AssignedRawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * @throws JsonException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cart_items' => 'required|json',
        ]);

        $cartItems = json_decode($request->cart_items, true, 512, JSON_THROW_ON_ERROR);

        foreach ($cartItems as $item) {
            $orderPreparationId = $item['order_id'];
            $quantity = $item['used_qty'];
            $type = $item['type'];
            $materialId = $item['material_id'];

            if ($type === 'local') {
                // Store in assigned_raw_materials
                DB::table('assigned_raw_materials')->insert([
                    'order_preperation_id' => $orderPreparationId,
                    'raw_material_store_id' => $materialId,
                    'assigned_quantity' => $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif ($type === 'export') {
                // Store in assigned_raw_material_exports
                DB::table('assigned_raw_material_exports')->insert([
                    'order_preperation_id' => $orderPreparationId,
                    'export_raw_material_id' => $materialId,
                    'assigned_quantity' => $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Clear the cart after storing
        Session::flash('success', 'Raw materials assigned successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignedRawMaterial $assignedRawMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssignedRawMaterial $assignedRawMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssignedRawMaterial $assignedRawMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignedRawMaterial $assignedRawMaterial)
    {
        //
    }
}

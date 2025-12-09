<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use JsonException;
use RuntimeException;

class AssignedRawMaterialController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @throws JsonException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cart_items' => 'required|json',
        ]);

        $cartItems = json_decode($request->input('cart_items'), true, 512, JSON_THROW_ON_ERROR);

        DB::beginTransaction();

        try {
            foreach ($cartItems as $item) {

                $orderPreparationId = $item['order_id'];
                $quantity = (int)$item['used_qty'];
                $type = $item['type'];
                $materialId = $item['material_id'];
                $assignedSection = $item['productionType'];

                if ($type === 'local') {
                    // Fetch material
                    $material = DB::table('raw_material_stores')->where('id', $materialId)->first();

                    if (!$material) {
                        throw new RuntimeException("Local raw material not found.");
                    }

                    if ($material->available_quantity < $quantity) {
                        throw new RuntimeException("Insufficient stock for material ID $materialId.");
                    }

                    DB::table('product_order_preperations')
                        ->where('id', $orderPreparationId)
                        ->update([
                            'isOrderAssigned' => true,
                            'order_assigned_date' => now(),
                            'status' => 'Assigned',
                            'orderAssignedTo' => $assignedSection,
                            'updated_at' => now(),
                        ]);

                    // Store assignment
                    DB::table('assigned_raw_materials')->insert([
                        'order_preperation_id' => $orderPreparationId,
                        'raw_material_store_id' => $materialId,
                        'assigned_quantity' => $quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Reduce stock
                    DB::table('raw_material_stores')
                        ->where('id', $materialId)
                        ->update([
                            'available_quantity' => $material->available_quantity - $quantity,
                            'updated_at' => now(),
                        ]);

                } elseif ($type === 'export') {

                    // Fetch export material
                    $material = DB::table('export_raw_materials')->where('id', $materialId)->first();

                    if (!$material) {
                        throw new RuntimeException("Export raw material not found.");
                    }

                    if ($material->net_weight < $quantity) {
                        throw new RuntimeException("Insufficient stock for export material ID $materialId.");
                    }

                    // Store assignment
                    DB::table('assigned_raw_material_exports')->insert([
                        'order_preperation_id' => $orderPreparationId,
                        'export_raw_material_id' => $materialId,
                        'assigned_quantity' => $quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Reduce stock
                    DB::table('export_raw_materials')
                        ->where('id', $materialId)
                        ->update([
                            'net_weight' => $material->net_weight - $quantity,
                            'updated_at' => now(),
                        ]);
                }
            }

            DB::commit();

            Session::flash('success', 'Raw materials assigned and stock updated successfully!');
            return redirect()->back();

        } catch (Exception $e) {

            DB::rollBack();

            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}

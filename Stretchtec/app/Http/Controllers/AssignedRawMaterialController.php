<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

            // Capture these only once (from the first item)
            $firstItem = $cartItems[0];
            $assignedSection = $firstItem['productionType'];
            $orderPreparationId = $firstItem['order_id'];

            //Find the product inquiry id related to this order preparation
            $productInquiryId = DB::table('product_order_preperations')
                ->where('id', $orderPreparationId)
                ->value('product_inquiry_id');

            //Find the prod order no related to this order preparation
            $prodOrderNo = DB::table('product_order_preperations')
                ->where('id', $orderPreparationId)
                ->value('prod_order_no');

            foreach ($cartItems as $item) {

                $orderPreparationId = $item['order_id'];
                $quantity = (int)$item['used_qty'];
                $type = $item['type'];
                $materialId = $item['material_id'];
                $assignedSection = $item['productionType'];

                if ($type === 'local') {

                    $material = DB::table('raw_material_stores')->where('id', $materialId)->first();
                    if (!$material) {
                        throw new RuntimeException("Local raw material not found.");
                    }
                    if ($material->available_quantity < $quantity) {
                        throw new RuntimeException("Insufficient stock for material ID $materialId.");
                    }

                    // Mark order as assigned
                    DB::table('product_order_preperations')
                        ->where('id', $orderPreparationId)
                        ->update([
                            'isOrderAssigned' => true,
                            'order_assigned_date' => now(),
                            'status' => 'Assigned',
                            'orderAssignedTo' => $assignedSection,
                            'updated_at' => now(),
                        ]);

                    // Store assigned raw material
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

                    $material = DB::table('export_raw_materials')->where('id', $materialId)->first();
                    if (!$material) {
                        throw new RuntimeException("Export raw material not found.");
                    }
                    if ($material->net_weight < $quantity) {
                        throw new RuntimeException("Insufficient stock for export material ID $materialId.");
                    }

                    DB::table('assigned_raw_material_exports')->insert([
                        'order_preperation_id' => $orderPreparationId,
                        'export_raw_material_id' => $materialId,
                        'assigned_quantity' => $quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::table('export_raw_materials')
                        ->where('id', $materialId)
                        ->update([
                            'net_weight' => $material->net_weight - $quantity,
                            'updated_at' => now(),
                        ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | INSERT INTO PRODUCTION SECTION TABLE — RUN ONLY ONCE
            |--------------------------------------------------------------------------
            */
            if ($assignedSection === 'Knitted') {
                DB::table('knitted_section_orders')->insert([
                    'order_preperation_id' => $orderPreparationId,
                    'product_inquiry_id' => $productInquiryId,
                    'prod_order_no' => $prodOrderNo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif ($assignedSection === 'Loom') {
                DB::table('loom_section_orders')->insert([
                    'order_preperation_id' => $orderPreparationId,
                    'product_inquiry_id' => $productInquiryId,
                    'prod_order_no' => $prodOrderNo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif ($assignedSection === 'Braiding') {
                DB::table('braiding_section_orders')->insert([
                    'order_preperation_id' => $orderPreparationId,
                    'product_inquiry_id' => $productInquiryId,
                    'prod_order_no' => $prodOrderNo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            Session::flash('success', 'Raw materials assigned and production order created successfully!');
            return redirect()->back();

        } catch (Exception $e) {

            DB::rollBack();

            Session::flash('error', $e->getMessage());
            Log::error('Error assigning raw materials: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}

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
use Throwable;

class AssignedRawMaterialController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @throws JsonException
     * @throws Throwable
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
            $orderPrep = DB::table('product_order_preperations')
                ->where('id', $orderPreparationId)
                ->first();

            $productInquiryId = $orderPrep->product_inquiry_id;
            $mailBookingId = $orderPrep->mail_booking_id ?? null; // Assuming mail_booking_id is added to product_order_preperations
            $prodOrderNo = $orderPrep->prod_order_no;

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
            // Prepare common data for insertion
            $insertData = [
                'order_preperation_id' => $orderPreparationId,
                'prod_order_no' => $orderPrep->prod_order_no,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Explicitly handle Product Inquiry vs Mail Booking
            if (!empty($orderPrep->product_inquiry_id)) {
                $insertData['product_inquiry_id'] = $orderPrep->product_inquiry_id;
                $insertData['mail_booking_id'] = null;
            } elseif (!empty($orderPrep->mail_booking_id)) {
                $insertData['product_inquiry_id'] = null;
                $insertData['mail_booking_id'] = $orderPrep->mail_booking_id;
            } else {
                // Should ideally not happen if data integrity is maintained
                $insertData['product_inquiry_id'] = null;
                $insertData['mail_booking_id'] = null;
            }

            if ($assignedSection === 'Knitted') {
                DB::table('knitted_section_orders')->insert($insertData);
            } elseif ($assignedSection === 'Loom') {
                DB::table('loom_section_orders')->insert($insertData);
            } elseif ($assignedSection === 'Braiding') {
                DB::table('braiding_section_orders')->insert($insertData);
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

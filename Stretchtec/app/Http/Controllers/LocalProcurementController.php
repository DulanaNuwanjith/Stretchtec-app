<?php

namespace App\Http\Controllers;

use App\Models\LocalProcurement;
use App\Models\ProductOrderPreperation;
use App\Models\PurchaseDepartment;
use App\Models\RawMaterialStore;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LocalProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $localProcurements = LocalProcurement::orderBy('id', 'desc')->paginate(10);

        $poNumbers = PurchaseDepartment::distinct()->pluck('po_number')->toArray();

        $orderPreparations = ProductOrderPreperation::where('isRawMaterialOrdered', 1)
            ->where('isRawMaterialReceived', 0)
            ->latest()
            ->get();

        return view('purchasingDepartment.localinvoiceManage', compact('localProcurements', 'poNumbers', 'orderPreparations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ?RedirectResponse
    {
        try {
            // Validate master invoice fields
            $validatedMaster = $request->validate([
                'date' => 'required|date',
                'invoice_number' => 'required|string|unique:local_procurements,invoice_number',
                'po_number' => 'required|string|exists:purchase_departments,po_number',
                'supplier_name' => 'required|string',
            ]);

            // Validate items (array)
            $validatedItems = $request->validate([
                'items' => 'required|array|min:1',
                'items.*.color' => 'required|string',
                'items.*.shade' => 'required|string',
                'items.*.tkt' => 'required|string',
                'items.*.uom' => 'required|string',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.pst_no' => 'nullable|string',
                'items.*.supplier_comment' => 'nullable|string',
            ]);

            // Begin transaction
            DB::beginTransaction();

            foreach ($validatedItems['items'] as $item) {
                // Create a local procurement record
                LocalProcurement::create([
                    'invoice_number' => $validatedMaster['invoice_number'],
                    'po_number' => $validatedMaster['po_number'],
                    'date' => $validatedMaster['date'],
                    'supplier_name' => $validatedMaster['supplier_name'],
                    'color' => $item['color'],
                    'shade' => $item['shade'],
                    'tkt' => $item['tkt'],
                    'uom' => $item['uom'],
                    'quantity' => $item['quantity'],
                    'pst_no' => $item['pst_no'] ?? null,
                    'supplier_comment' => $item['supplier_comment'] ?? null,
                ]);

                // Add corresponding raw material entry
                RawMaterialStore::create([
                    'date' => $validatedMaster['date'],
                    'color' => $item['color'],
                    'shade' => $item['shade'],
                    'pst_no' => $item['pst_no'] ?? null,
                    'tkt' => $item['tkt'],
                    'supplier' => $validatedMaster['supplier_name'],
                    'available_quantity' => $item['quantity'],
                    'unit' => $item['uom'],
                    'remarks' => $item['supplier_comment'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Local procurement and raw material records created successfully.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Local Procurement Creation Error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'An error occurred while creating the procurement and raw material records.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LocalProcurement $localProcurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LocalProcurement $localProcurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LocalProcurement $localProcurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocalProcurement $localProcurement)
    {
        //
    }
}

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
        $uniqueInvoiceNumbers = LocalProcurement::select('invoice_number')
            ->groupBy('invoice_number')
            ->orderBy('date', 'desc')
            ->paginate(10);

        $invoiceItems = LocalProcurement::whereIn('invoice_number', $uniqueInvoiceNumbers->pluck('invoice_number'))
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('invoice_number');

        $orderPreparations = ProductOrderPreperation::where('isRawMaterialOrdered', 1)
            ->where('isRawMaterialReceived', 0)
            ->latest()
            ->get();

        $poNumbers = PurchaseDepartment::orderBy('po_date', 'desc')
            ->pluck('po_number')
            ->unique();

        return view('purchasingDepartment.localinvoiceManage', compact('uniqueInvoiceNumbers', 'invoiceItems', 'orderPreparations', 'poNumbers'));
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
                'total_quantity' => 'required|numeric|min:1',
                'invoice_value' => 'required|numeric|min:0',
                'checked_by' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            // Validate items (array)
            $validatedItems = $request->validate([
                'items' => 'required|array|min:1',
                'items.*.color' => 'required|string',
                'items.*.shade' => 'required|string',
                'items.*.tkt' => 'required|string',
                'items.*.uom' => 'required|string',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
                'items.*.total_price' => 'required|numeric|min:0',
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
                    'approved_by' => $validatedMaster['checked_by'] ?? null,
                    'color' => $item['color'],
                    'shade' => $item['shade'],
                    'tkt' => $item['tkt'],
                    'uom' => $item['uom'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                    'total_quantity' => $validatedMaster['total_quantity'],
                    'invoice_value' => $validatedMaster['invoice_value'],
                    'notes' => $validatedMaster['notes'] ?? null,
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
                    'unit_price' => $item['unit_price'],
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

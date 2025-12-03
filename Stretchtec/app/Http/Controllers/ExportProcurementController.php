<?php

namespace App\Http\Controllers;

use App\Models\ExportProcurement;
use App\Models\ExportRawMaterial;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ExportProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $uniqueInvoiceNumbers = ExportProcurement::select('invoice_number')
            ->groupBy('invoice_number')
            ->orderBy('date', 'desc')
            ->paginate(10);

        $invoiceItems = ExportProcurement::whereIn('invoice_number', $uniqueInvoiceNumbers->pluck('invoice_number'))
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('invoice_number');

        return view('purchasingDepartment.exportinvoiceManage', compact('uniqueInvoiceNumbers', 'invoiceItems'));
    }

    public function exportRawIndex(): Factory|View
    {
        $exportRawMaterials = ExportRawMaterial::latest()->paginate(10);
        return view('store-management.pages.rawMaterialReceipt', compact('exportRawMaterials'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request): ?RedirectResponse
    {
        try {
            // Validate master invoice fields
            $validatedMaster = $request->validate([
                'date' => 'required|date',
                'invoice_number' => 'required|string|unique:export_procurements,invoice_number',
                'supplier' => 'required|string',
                'total_weight' => 'required|numeric|min:0',
                'invoice_value' => 'required|numeric|min:0',
                'checked_by' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            // Validate item array fields
            $validatedItems = $request->validate([
                'items' => 'required|array|min:1',

                'items.*.product_description' => 'required|string',
                'items.*.net_weight' => 'required|numeric|min:0',
                'items.*.unit_price' => 'required|numeric|min:0',
                'items.*.total_amount' => 'required|numeric|min:0',
                'items.*.uom' => 'required|string',
            ]);

            DB::beginTransaction();

            foreach ($validatedItems['items'] as $item) {

                ExportProcurement::create([
                    'date' => $validatedMaster['date'],
                    'invoice_number' => $validatedMaster['invoice_number'],
                    'supplier' => $validatedMaster['supplier'],

                    'product_description' => $item['product_description'],
                    'net_weight' => $item['net_weight'],
                    'unit_price' => $item['unit_price'],
                    'total_amount' => $item['total_amount'],
                    'uom' => $item['uom'] ?? null,

                    'total_weight' => $validatedMaster['total_weight'],
                    'invoice_value' => $validatedMaster['invoice_value'],
                    'checked_by' => $validatedMaster['checked_by'] ?? null,
                    'notes' => $validatedMaster['notes'] ?? null,
                ]);

                ExportRawMaterial::create([
                    'supplier' => $validatedMaster['supplier'],
                    'product_description' => $item['product_description'],
                    'net_weight' => $item['net_weight'],
                    'unit_price' => $item['unit_price'],
                    'uom' => $item['uom'] ?? null,
                    'notes' => $validatedMaster['notes'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Export procurement records created successfully.');

        } catch (ValidationException $e) {

            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Export Procurement Creation Error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'An unexpected error occurred while creating export procurement records.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExportProcurement $exportProcurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExportProcurement $exportProcurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExportProcurement $exportProcurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExportProcurement $exportProcurement)
    {
        //
    }
}

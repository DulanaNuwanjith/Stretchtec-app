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
    public function index(Request $request): Factory|View
    {
        // Start query
        $query = ExportProcurement::query();

        // Apply filters if present
        if ($request->filled('invoice_number')) {
            $query->where('invoice_number', $request->invoice_number);
        }

        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Get unique invoice numbers with pagination
        $uniqueInvoiceNumbers = $query->select('invoice_number')
            ->groupBy('invoice_number')
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString(); // preserve filter query params

        // Get invoice items for listed invoice numbers
        $invoiceItems = ExportProcurement::whereIn('invoice_number', $uniqueInvoiceNumbers->pluck('invoice_number'))
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('invoice_number');

        return view('purchasingDepartment.exportinvoiceManage', compact('uniqueInvoiceNumbers', 'invoiceItems'));
    }


    public function exportRawIndex(): Factory|View
    {
        $query = ExportRawMaterial::query();

        if ($supplier = request('supplier')) {
            $query->where('supplier', 'like', "%{$supplier}%");
        }

        if ($product = request('product_description')) {
            $query->where('product_description', 'like', "%{$product}%");
        }

        $exportRawMaterials = $query->latest()->paginate(20);

        // Get unique suppliers for the dropdown
        $suppliers = ExportRawMaterial::select('supplier')->distinct()->pluck('supplier');

        // You can also get product descriptions if needed
        $products = ExportRawMaterial::select('product_description')->distinct()->pluck('product_description');

        return view(
            'store-management.pages.rawMaterialReceipt',
            compact('exportRawMaterials', 'suppliers', 'products')
        );
    }

    public function exportRawStore(Request $request): RedirectResponse
    {
        // 1. Validate incoming request data
        $validated = $request->validate([
            'supplier'            => 'required|string|max:255',
            'product_description' => 'required|string|max:255',
            'net_weight'          => 'required|numeric|min:0.01',
            'uom'                 => 'required|string|max:50',
            'unit_price'          => 'required|numeric|min:0.01',
            'notes'               => 'nullable|string|max:500',
        ]);

        // 2. Save into a database
        ExportRawMaterial::create([
            'supplier'            => $validated['supplier'],
            'product_description' => $validated['product_description'],
            'net_weight'          => $validated['net_weight'],
            'uom'                 => $validated['uom'],
            'unit_price'          => $validated['unit_price'],
            'notes'               => $validated['notes'] ?? null,
        ]);

        // 3. Redirect or return success response
        return redirect()->back()->with('success', 'Export raw material added successfully.');
    }

    public function exportRawDelete($id): RedirectResponse
    {
        $exportRaw = ExportRawMaterial::findOrFail($id);

        $exportRaw->delete();

        return redirect()
            ->back()
            ->with('success', 'Raw material record deleted successfully.');
    }

    public function borrowExportRawMaterial(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'borrow_qty' => 'required|numeric|min:0.01',
        ]);

        $material = ExportRawMaterial::findOrFail($id);

        // Prevent borrowing more than available net_weight
        if ($material->net_weight < $request->borrow_qty) {
            return back()->with('error', 'Insufficient quantity to borrow.');
        }

        // Deduct quantity
        $material->net_weight -= $request->borrow_qty;

        if ($material->net_weight <= 0) {
            // Delete record if all quantity borrowed
            $material->delete();
            return back()->with('success', 'All quantity borrowed. Record deleted.');
        } else {
            $material->save();
            return back()->with('success', 'Borrowed ' . $request->borrow_qty . ' ' . $material->uom . ' successfully!');
        }
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
    public function destroy($id)
    {
        try {
            // find the specific row
            $record = ExportProcurement::findOrFail($id);

            // delete ALL rows under this invoice number
            ExportProcurement::where('invoice_number', $record->invoice_number)->delete();

            return back()->with('success', 'Invoice and all its items deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting invoice: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete the invoice.');
        }
    }
}

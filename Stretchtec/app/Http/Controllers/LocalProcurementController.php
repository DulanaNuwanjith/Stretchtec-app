<?php

namespace App\Http\Controllers;

use App\Models\LocalProcurement;
use App\Models\PurchaseDepartment;
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

        $poNumbers = PurchaseDepartment::pluck('po_number')->toArray();

        return view('purchasingDepartment.localinvoiceManage', compact('localProcurements', 'poNumbers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ?RedirectResponse
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'date' => 'required|date',
                'invoice_number' => 'required|string|unique:local_procurements,invoice_number',
                'po_number' => 'required|string|exists:purchase_departments,po_number',
                'supplier_name' => 'required|string',
                'color' => 'required|string',
                'shade' => 'required|string',
                'tkt' => 'required|string',
                'uom' => 'required|string',
                'quantity' => 'required|numeric',
                'pst_no' => 'nullable|string',
                'supplier_comment' => 'nullable|string',
            ]);

            // Begin transaction for data consistency
            DB::beginTransaction();

            // Only use validated data for creation
            LocalProcurement::create($validated);

            // Commit transaction
            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Local procurement record created successfully.');

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
                ->with('error', 'An error occurred while creating the procurement record.')
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

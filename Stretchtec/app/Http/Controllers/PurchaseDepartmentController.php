<?php

namespace App\Http\Controllers;

use App\Models\ProductOrderPreperation;
use App\Models\PurchaseDepartment;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $purchaseDepartments = PurchaseDepartment::latest()->paginate(10);
        $orderPreparations = ProductOrderPreperation::where('isRawMaterialOrdered', false)
            ->latest()
            ->get();
        return view('purchasingDepartment.purchasing', compact('purchaseDepartments', 'orderPreparations'));
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
     */
    public function store(Request $request): ?RedirectResponse
    {
        $validated = $request->validate([
            'po_number' => 'required|string|max:255',
            'po_date' => 'required|date',
            'supplier' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected',
            'items' => 'required|array|min:1',

            // validate array fields
            'items.*.shade' => 'required|string',
            'items.*.color' => 'required|string',
            'items.*.tkt' => 'required|string',
            'items.*.pst_no' => 'nullable|string',
            'items.*.supplier_comment' => 'nullable|string',
            'items.*.uom' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated['items'] as $item) {
                PurchaseDepartment::create([
                    'po_number' => $validated['po_number'],
                    'po_date' => $validated['po_date'],
                    'supplier' => $validated['supplier'],
                    'shade' => $item['shade'],
                    'color' => $item['color'],
                    'tkt' => $item['tkt'],
                    'pst_no' => $item['pst_no'] ?? null,
                    'supplier_comment' => $item['supplier_comment'] ?? null,
                    'uom' => $item['uom'],
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'amount' => $item['amount'],
                    'total_amount' => $validated['total_amount'],
                    'status' => $validated['status'],
                ]);
            }

            DB::commit();
            return back()->with('success', 'Purchase Order with multiple items created successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error saving purchase order: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating the purchase order.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseDepartment $purchaseDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseDepartment $purchaseDepartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseDepartment $purchaseDepartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseDepartment $purchaseDepartment)
    {
        //
    }
}

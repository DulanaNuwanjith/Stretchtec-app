<?php

namespace App\Http\Controllers;

use App\Models\ProductInquiry;
use App\Models\SampleStock;
use App\Models\Stock;
use App\Models\Stores;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory
    {
        // Get search term if any
        $search = $request->input('search');

        // Query with optional search filter
        $query = SampleStock::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%$search%")
                    ->orWhere('shade', 'like', "%$search%")
                    ->orWhere('special_note', 'like', "%$search%");
            });
        }

        // Paginate results, e.g. 10 per page
        $sampleStocks = $query->orderBy('reference_no')->paginate(10);

        $sampleStocks->appends(['search' => $search]);

        return view('store-management.storeManagement', compact('sampleStocks', 'search'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Stores $stores): void
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stores $stores): void
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stores $stores): void
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stores $stores): void
    {
        //
    }

    public function assign(Request $request, $id): RedirectResponse
    {
        // Validate request
        $validated = $request->validate([
            'qty_allocated' => 'required|numeric|min:0',
            'allocated_uom' => 'required|string|in:meters,yards,pieces',
            'reason_for_reject' => 'nullable|string'
        ]);

        // Find the store, stock, and product inquiry records
        $store = Stores::findOrFail($id);
        $stock = Stock::where('reference_no', $store->reference_no)->firstOrFail();
        $productInquiry = ProductInquiry::where('prod_order_no', $store->prod_order_no)->firstOrFail();

        $requestedUom = $validated['allocated_uom'];
        $allocatedQtyInYards = $validated['qty_allocated'];

        // ✅ Step 1: Ensure allocated UOM matches the customer's requested UOM
        if ($productInquiry->uom !== $requestedUom) {
            return back()->withErrors([
                'allocated_uom' => "Allocated UOM must match the customer's requested UOM ({$productInquiry->uom})."
            ]);
        }

        // ✅ Step 2: Convert allocated qty into yards (if necessary)
        if ($requestedUom === 'meters') {
            // Convert meters → yards
            $allocatedQtyInYards = $validated['qty_allocated'] * 1.09361;
        } elseif ($requestedUom === 'yards') {
            // Already in yards
            $allocatedQtyInYards = $validated['qty_allocated'];
        } elseif ($requestedUom === 'pieces') {
            // Pieces: must only be deducted if stock is also in pieces
            if ($stock->uom !== 'pieces') {
                return back()->withErrors([
                    'qty_allocated' => 'Cannot allocate pieces from stock measured in ' . $stock->uom
                ]);
            }
            $allocatedQtyInYards = $validated['qty_allocated'];
        }

        // ✅ Step 3: Decrease the stock qty
        if ($stock->qty_available >= $allocatedQtyInYards) {
            $stock->qty_available -= $allocatedQtyInYards;
            $stock->save();
        } else {
            return back()->withErrors([
                'qty_allocated' => 'Not enough stock available to allocate.'
            ]);
        }

        // ✅ Step 4: Update store fields
        $store->qty_allocated = $validated['qty_allocated'];
        $store->reason_for_reject = $validated['reason_for_reject'] ?? null;
        $store->is_qty_assigned = true;
        $store->assigned_by = auth()->user()->name ?? 'System';
        $store->allocated_uom = substr(strtolower($requestedUom), 0, 1);

        if ($store->qty_available >= $store->qty_allocated) {
            $store->qty_available -= $store->qty_allocated;
        } else {
            return back()->withErrors([
                'qty_allocated' => 'Allocated qty cannot exceed available qty.'
            ]);
        }

        $store->save();

        // ✅ Step 5: Allow sending to production
        $productInquiry->canSendToProduction = true;
        $productInquiry->save();

        return redirect()->back()->with('success', 'Quantity assigned successfully!');
    }
}

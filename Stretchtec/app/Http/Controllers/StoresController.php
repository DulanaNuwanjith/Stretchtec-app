<?php

namespace App\Http\Controllers;

use App\Models\ProductInquiry;
use App\Models\SampleStock;
use App\Models\Stock;
use App\Models\Stores;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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
        // validate qty_allocated before updating
        $validated = $request->validate([
            'qty_allocated' => 'required|integer|min:0',
            'reason_for_reject' => 'nullable|string'
        ]);

        // find the store record
        $store = Stores::findOrFail($id);

        //Find the stock record
        $stock = Stock::where('reference_no', $store->reference_no)->firstOrFail();

        //Find the Product inquiry record
        $productInquiry = ProductInquiry::where('prod_order_no', $store->prod_order_no)->firstOrFail();

        // Decrease the stock qty
        if ($stock->qty_available >= $request->qty_allocated) {
            $stock->qty_available -= $request->qty_allocated;
            $stock->save();
        } else {
            return back()->withErrors(['qty_allocated' => 'Not enough stock available to allocate.']);
        }

        // update fields
        $store->qty_allocated = $validated['qty_allocated'];
        $store->reason_for_reject = $validated['reason_for_reject'] ?? null;
        $store->is_qty_assigned = true;
        $store->assigned_by = auth()->user()->name ?? 'System';

        // optionally reduce available qty
        if ($store->qty_available >= $store->qty_allocated) {
            $store->qty_available = $store->qty_available - $store->qty_allocated;
        } else {
            return back()->withErrors(['qty_allocated' => 'Allocated qty cannot exceed available qty']);
        }

        $store->save();

        $productInquiry->canSendToProduction = true;
        $productInquiry->save();

        return redirect()->back()->with('success', 'Quantity assigned successfully!');
    }

}

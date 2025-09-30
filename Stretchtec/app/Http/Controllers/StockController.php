<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stock = Stock::orderBy('id', 'asc')->paginate(10);
        return view('store-management.pages.stockManagement', compact('stock'));
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
    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'reference_no'     => 'required|string|max:255',
            'shade'            => 'required|string|max:255',
            'available_stock'  => 'required|integer|min:0',
            'special_note'     => 'nullable|string|max:500',
        ]);

        try {
            // Create a new stock entry
            $stock = new Stock();
            $stock->reference_no    = $validated['reference_no'];
            $stock->shade           = $validated['shade'];
            $stock->qty_available = $validated['available_stock'];
            $stock->notes    = $validated['special_note'] ?? null;
            $stock->save();

            return redirect()->back()->with('success', 'Stock item created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating stock item: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}

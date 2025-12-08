<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Stores;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Stock::query();

        if ($request->filled('reference_no')) {
            $query->where('reference_no', $request->reference_no);
        }

        if ($request->filled('shade')) {
            $query->where('shade', $request->shade);
        }

        $stock = $query->orderBy('id', 'asc')->paginate(20);

        $referenceNos = Stock::select('reference_no')->distinct()->pluck('reference_no');
        $shades = Stock::select('shade')->distinct()->pluck('shade');

        return view('store-management.pages.stockManagement', compact('stock', 'referenceNos', 'shades'));
    }

    public function storeManageIndex(): Factory|View
    {
        // Order by latest created record
        $stores = Stores::orderBy('id', 'desc')->paginate(20);

        return view('store-management.pages.storeAvailabilityCheck', compact('stores'));
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
    public function store(Request $request): RedirectResponse
    {
        // Validate inputs
        $validated = $request->validate([
            'reference_no' => 'required|string|max:255|unique:stocks,reference_no',
            'shade' => 'required|string|max:255',
            'available_stock' => 'required|integer|min:0',
            'special_note' => 'nullable|string|max:500',
            'uom' => 'required|string|in:m,y,pcs'
        ]);

        try {
            // Convert stock to yards if uom = meters
            $qtyInYards = $validated['available_stock'];

            if ($validated['uom'] === 'm') {
                $qtyInYards = $validated['available_stock'] * 1.09361; // meters → yards
            }

            // Create a new stock entry
            $stock = new Stock();
            $stock->reference_no = $validated['reference_no'];
            $stock->shade = $validated['shade'];
            $stock->qty_available = $qtyInYards;
            $stock->notes = $validated['special_note'] ?? null;
            $stock->uom = $validated['uom']; // store original uom for reference
            $stock->save();

            return redirect()->back()->with('success', 'Stock item created successfully!');
        } catch (Exception $e) {
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
    public function destroy($id): RedirectResponse
    {
        // Find the stock item by ID
        $stockItem = Stock::find($id);

        if (!$stockItem) {
            // If the item doesn't exist, redirect back with an error
            return redirect()->route('stockManagement.index')
                ->with('error', 'Stock item not found.');
        }

        try {
            $stockItem->delete(); // Delete the item
            return redirect()->route('stockManagement.index')
                ->with('success', 'Stock item deleted successfully.');
        } catch (Exception $e) {
            // Handle any exception that occurs
            return redirect()->route('stockManagement.index')
                ->with('error', 'Failed to delete stock item. Please try again.');
        }
    }

    public function addStock(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'stock_increment' => 'required|integer|min:1',
        ]);

        $stock = Stock::findOrFail($id);

        // Increase available stock
        $stock->qty_available += $request->stock_increment;
        $stock->save();

        return back()->with('success', 'Stock increased by ' . $request->stock_increment);
    }


    public function borrowStock(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'borrow_qty' => 'required|numeric|min:1',
        ]);

        $stock = Stock::findOrFail($id);

        // Prevent borrowing more than available
        if ($stock->qty_available < $request->borrow_qty) {
            return back()->with('error', 'Insufficient stock to borrow.');
        }

        // Deduct stock
        $stock->qty_available -= $request->borrow_qty;

        if ($stock->qty_available <= 0) {
            // Delete stock if nothing left
            $stock->delete();
            return back()->with('success', 'All stock borrowed. Item has been deleted.');
        } else {
            $stock->save();
            return back()->with('success', 'Borrowed ' . $request->borrow_qty . ' successfully!');
        }
    }

}

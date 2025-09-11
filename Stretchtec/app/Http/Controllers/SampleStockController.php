<?php

namespace App\Http\Controllers;

use App\Models\SampleStock;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class SampleStockController extends Controller
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

        // Preserve search query on pagination links
        $sampleStocks->appends(['search' => $search]);

        return view('sample-development.sample-stock-management', compact('sampleStocks', 'search'));
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
    public function store(Request $request): ?RedirectResponse
    {
        try {
            $request->validate([
                'reference_no' => 'required|string|max:255|unique:sample_stocks',
                'shade' => 'required|string|max:255',
                'available_stock' => 'required|integer|min:0',
                'special_note' => 'nullable|string|max:1000',
            ]);

            SampleStock::create([
                'reference_no' => $request->reference_no,
                'shade' => $request->shade,
                'available_stock' => $request->available_stock,
                'special_note' => $request->special_note,
            ]);

            return redirect()->back()->with('success', 'Sample stock created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create sample stock: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(SampleStock $sampleStock): void
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SampleStock $sampleStock): void
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'special_note' => 'nullable|string|max:1000',
        ]);

        $stock = SampleStock::findOrFail($id);
        $stock->special_note = $request->special_note;
        $stock->save();

        return back()->with('success', 'Special note updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SampleStock $sampleStock): void
    {
        //
    }


    /**
     * Handle borrowing of stock.
     */
    public function borrow(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'borrow_qty' => 'required|integer|min:1',
        ]);

        $stock = SampleStock::findOrFail($id);
        $borrowQty = $request->borrow_qty;

        if ($borrowQty > $stock->available_stock) {
            return redirect()->back()->withErrors(['borrow_qty' => 'Borrowing quantity exceeds available stock.']);
        }

        // Subtract borrowed quantity
        $stock->available_stock -= $borrowQty;

        // If stock becomes 0, delete it
        if ($stock->available_stock === 0) {
            $stock->delete();
            return redirect()->back()->with('success', 'Stock fully borrowed and record removed.');
        }

        $stock->save();
        return redirect()->back()->with('success', 'Stock borrowed successfully.');
    }
}

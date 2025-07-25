<?php

namespace App\Http\Controllers;

use App\Models\SampleStock;
use Illuminate\Http\Request;

class SampleStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sampleStocks = SampleStock::all();
        return view('sample-development.sample-stock-management', compact('sampleStocks'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SampleStock $sampleStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SampleStock $sampleStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
    public function destroy(SampleStock $sampleStock)
    {
        //
    }

    public function borrow(Request $request, $id)
    {
        $request->validate([
            'borrow_qty' => 'required|integer|min:1',
        ]);

        $stock = SampleStock::findOrFail($id);

        $borrowQty = $request->borrow_qty;

        if ($borrowQty > $stock->available_stock) {
            return redirect()->back()->withErrors(['borrow_qty' => 'Borrowing quantity exceeds available stock.']);
        }

        $stock->available_stock -= $borrowQty;

        if ($stock->available_stock == 0) {
            $stock->special_note = 'No more stock available';
        }

        $stock->save();

        return redirect()->back()->with('success', 'Stock borrowed successfully.');
    }

}

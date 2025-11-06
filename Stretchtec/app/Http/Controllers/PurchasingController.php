<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $purchasings = Purchasing::all();
        return view('purchasingDepartment.purchasing', compact('purchasings'));
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
    $validated = $request->validate([
        'order_no' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'shade' => 'required|string|max:255',
        'pst_no' => 'nullable|string|max:255',
        'tkt' => 'nullable|string|max:255',
        'supplier_comment' => 'nullable|string|max:255',
        'type' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
    ]);

    Purchasing::create($validated);

    return back()->with('success', 'Purchase order added successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(Purchasing $purchasing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchasing $purchasing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchasing $purchasing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchasing $purchasing)
    {
        //
    }
}

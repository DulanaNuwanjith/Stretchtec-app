<?php

namespace App\Http\Controllers;

use App\Models\RawMaterialStore;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RawMaterialStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $rawMaterials = RawMaterialStore::paginate(10);
        return view('store-management.pages.rawMaterial', compact('rawMaterials'));
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'color' => 'required|string|max:255',
            'shade' => 'required|string|max:255',
            'pst_no' => 'nullable|string|max:255',
            'tkt' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'available_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        RawMaterialStore::create($validated);

        return redirect()->route('rawMaterial.index')->with('success', 'Raw material added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterialStore $rawMaterialStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterialStore $rawMaterialStore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RawMaterialStore $rawMaterialStore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $rawMaterial = RawMaterialStore::findOrFail($id);
        $rawMaterial->delete();

        return redirect()->route('rawMaterial.index')->with('success', 'Raw material deleted successfully!');
    }
}

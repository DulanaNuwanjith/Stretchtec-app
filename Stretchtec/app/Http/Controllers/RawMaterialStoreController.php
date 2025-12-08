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
   public function index(Request $request): View
    {
        $query = RawMaterialStore::query();

        // Apply Filters
        if ($request->color) {
            $query->where('color', $request->color);
        }

        if ($request->shade) {
            $query->where('shade', $request->shade);
        }

        if ($request->pst_no) {
            $query->where('pst_no', $request->pst_no);
        }

        if ($request->supplier) {
            $query->where('supplier', $request->supplier);
        }

        $rawMaterials = $query->paginate(20)->appends($request->query());

        // NEW — Send Dropdown Filter Data
        $colors = RawMaterialStore::select('color')->distinct()->pluck('color');
        $shades = RawMaterialStore::select('shade')->distinct()->pluck('shade');
        $psts = RawMaterialStore::select('pst_no')->distinct()->pluck('pst_no');
        $suppliers = RawMaterialStore::select('supplier')->distinct()->pluck('supplier');

        return view('store-management.pages.rawMaterial', compact(
            'rawMaterials',
            'colors',
            'shades',
            'psts',
            'suppliers'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
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
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $rawMaterial = RawMaterialStore::findOrFail($id);
        $rawMaterial->delete();

        return redirect()->route('rawMaterial.index')->with('success', 'Raw material deleted successfully!');
    }

    public function borrow(Request $request, $id)
    {
        $request->validate([
            'borrow_qty' => 'required|numeric|min:1',
        ]);

        $material = RawMaterialStore::findOrFail($id);

        if ($material->available_quantity < $request->borrow_qty) {
            return back()->with('error', 'Insufficient quantity to borrow.');
        }

        // Reduce quantity
        $material->available_quantity -= $request->borrow_qty;

        // If becomes zero, delete record
        if ($material->available_quantity <= 0) {
            $material->delete();
            return back()->with('success', 'All quantity borrowed. Record deleted!');
        }

        $material->save();

        return back()->with('success', 'Borrowed ' . $request->borrow_qty . ' units successfully!');
    }


}

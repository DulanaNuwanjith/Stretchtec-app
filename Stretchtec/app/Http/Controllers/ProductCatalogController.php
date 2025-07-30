<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    // Display a listing of the product catalog entries
    public function elasticCatalog()
    {
        $catalogs = ProductCatalog::where('item', 'Elastic')
                    ->latest()
                    ->paginate(15);

        return view('production-catalog.pages.elasticCatalog', compact('catalogs'));
    }

    public function tapeCatalog()
    {
        $catalogs = ProductCatalog::where('item', 'Tape')
                    ->latest()
                    ->paginate(15);

        return view('production-catalog.pages.tapeCatalog', compact('catalogs'));
    }

    public function codeCatalog()
    {
        $catalogs = ProductCatalog::where('item', 'Code')
                    ->latest()
                    ->paginate(15);

        return view('production-catalog.pages.codeCatalog', compact('catalogs'));
    }


    // Show the form for creating a new product catalog entry (optional)
    public function create()
    {
        return view('product-catalog.create');
    }

    // Store a newly created product catalog entry in storage
    public function store(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'reference_added_date' => 'nullable|date',
            'coordinator_name' => 'nullable|string|max:255',
            'item' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'colour' => 'nullable|string|max:255',
            'shade' => 'nullable|string|max:255',
            'tkt' => 'nullable|string|max:255',
        ]);

        ProductCatalog::create($request->all());

        return redirect()->route('product-catalog.index')->with('success', 'Catalog entry created.');
    }

    // Show the form for editing the specified product catalog entry
    public function edit(ProductCatalog $productCatalog)
    {
        return view('product-catalog.edit', compact('productCatalog'));
    }

    // Update the specified product catalog entry
    public function update(Request $request, ProductCatalog $productCatalog)
    {
        $request->validate([
            'order_no' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'reference_added_date' => 'nullable|date',
            'coordinator_name' => 'nullable|string|max:255',
            'item' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'colour' => 'nullable|string|max:255',
            'shade' => 'nullable|string|max:255',
            'tkt' => 'nullable|string|max:255',
        ]);

        $productCatalog->update($request->all());

        return redirect()->route('product-catalog.index')->with('success', 'Catalog entry updated.');
    }

    // Delete the specified product catalog entry
    public function destroy(ProductCatalog $productCatalog)
    {
        $productCatalog->delete();

        return redirect()->route('product-catalog.index')->with('success', 'Catalog entry deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use Illuminate\Support\Facades\Storage;
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

    // Store method forcing item = Elastic
    public function storeElastic(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string|max:255',
            'reference_no' => 'required|string|max:255',
            'reference_added_date' => 'nullable|date',
            'coordinator_name' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'colour' => 'nullable|string|max:255',
            'shade' => 'nullable|string|max:255',
            'tkt' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['item'] = 'Elastic'; // force item

        ProductCatalog::create($data);

        return redirect()->route('elasticCatalog.index')->with('success', 'Elastic catalog entry created.');
    }

    public function storeCode(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string|max:255',
            'reference_no' => 'required|string|max:255',
            'reference_added_date' => 'nullable|date',
            'coordinator_name' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'colour' => 'nullable|string|max:255',
            'shade' => 'nullable|string|max:255',
            'tkt' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['item'] = 'Code'; // force item

        ProductCatalog::create($data);

        return redirect()->route('codeCatalog.index')->with('success', 'Code catalog entry created.');
    }

    public function storeTape(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string|max:255',
            'reference_no' => 'required|string|max:255',
            'reference_added_date' => 'nullable|date',
            'coordinator_name' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'colour' => 'nullable|string|max:255',
            'shade' => 'nullable|string|max:255',
            'tkt' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['item'] = 'Tape'; // force item

        ProductCatalog::create($data);

        return redirect()->route('tapeCatalog.index')->with('success', 'Tape catalog entry created.');
    }

    public function uploadOrderImage(Request $request, ProductCatalog $catalog)
    {
        $request->validate([
            'order_image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('order_image')) {
            // Delete old image if exists
            if ($catalog->order_image && Storage::disk('public')->exists('order_images/' . $catalog->order_image)) {
                Storage::disk('public')->delete('order_images/' . $catalog->order_image);
            }

            // Store new image in storage/app/public/order_images
            $file = $request->file('order_image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('order_images', $filename, 'public');

            $catalog->order_image = $filename;
            $catalog->save();
        }

        return back()->with('success', 'Order image uploaded successfully.');
    }

    public function updateApproval(Request $request, ProductCatalog $productCatalog)
    {
        $request->validate([
            'approved_by' => 'nullable|string|max:255',
            'approval_card' => 'nullable|image|max:2048',
        ]);

        $updateData = [];

        // Handle approved_by
        if (!$productCatalog->is_approved_by_locked && $request->filled('approved_by')) {
            $updateData['approved_by'] = $request->input('approved_by');
            $updateData['is_approved_by_locked'] = true;
        }

        // Handle approval_card
        if (!$productCatalog->is_approval_card_locked && $request->hasFile('approval_card')) {
            // Delete old image if exists
            if ($productCatalog->approval_card && Storage::disk('public')->exists($productCatalog->approval_card)) {
                Storage::disk('public')->delete($productCatalog->approval_card);
            }

            $path = $request->file('approval_card')->store('approval_cards', 'public');
            $updateData['approval_card'] = $path;
            $updateData['is_approval_card_locked'] = true;
        }

        // Save updates if any
        if (!empty($updateData)) {
            $productCatalog->update($updateData);
        }

        return back()->with('success', 'Approval details updated successfully.');
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

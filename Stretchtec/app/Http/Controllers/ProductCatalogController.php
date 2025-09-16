<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the product catalog entries
     */
    public function elasticCatalog(Request $request): View|Factory
    {
        // Eager load shade orders using sample_preparation_rnd_id
        $query = ProductCatalog::with('shadeOrders')
            ->where('item', 'Elastic');

        // Apply filters
        if ($request->filled('orderNo')) {
            $query->where('order_no', $request->input('orderNo'));
        }

        if ($request->filled('merchandiser')) {
            $query->where('coordinator_name', $request->input('merchandiser'));
        }

        if ($request->filled('referenceNo')) {
            $query->where('reference_no', $request->input('referenceNo'));
        }

        $catalogs = $query->latest()->paginate(15)->appends($request->query());

        // Dropdown values for filtering (unique list)
        $orderNos = ProductCatalog::where('item', 'Elastic')->distinct()->pluck('order_no');
        $merchandisers = ProductCatalog::where('item', 'Elastic')->distinct()->pluck('coordinator_name');
        $referenceNos = ProductCatalog::where('item', 'Elastic')->distinct()->pluck('reference_no');

        return view('production-catalog.pages.elasticCatalog', compact(
            'catalogs', 'orderNos', 'merchandisers', 'referenceNos'
        ));
    }

    /**
     * Display a listing of the product catalog entries
     */
    public function codeCatalog(Request $request): View|Factory
    {
        // Eager load shade orders using sample_preparation_rnd_id
        $query = ProductCatalog::with('shadeOrders')
            ->where('item', 'Cord');

        // Apply filters
        if ($request->filled('orderNo')) {
            $query->where('order_no', $request->input('orderNo'));
        }

        if ($request->filled('merchandiser')) {
            $query->where('coordinator_name', $request->input('merchandiser'));
        }

        if ($request->filled('referenceNo')) {
            $query->where('reference_no', $request->input('referenceNo'));
        }

        $catalogs = $query->latest()->paginate(15)->appends($request->query());

        // Dropdown values for filtering (unique list)
        $orderNos = ProductCatalog::where('item', 'Cord')->distinct()->pluck('order_no');
        $merchandisers = ProductCatalog::where('item', 'Cord')->distinct()->pluck('coordinator_name');
        $referenceNos = ProductCatalog::where('item', 'Cord')->distinct()->pluck('reference_no');

        return view('production-catalog.pages.codeCatalog', compact(
            'catalogs', 'orderNos', 'merchandisers', 'referenceNos'
        ));
    }

    /**
     * Display a listing of the product catalog entries
     */
    public function tapeCatalog(Request $request): View|Factory
    {
        // Eager-load shade orders via sample_preparation_rnd_id
        $query = ProductCatalog::with('shadeOrders')
            ->where('item', 'Twill Tape');

        // Apply filters
        if ($request->filled('orderNo')) {
            $query->where('order_no', $request->input('orderNo'));
        }

        if ($request->filled('merchandiser')) {
            $query->where('coordinator_name', $request->input('merchandiser'));
        }

        if ($request->filled('referenceNo')) {
            $query->where('reference_no', $request->input('referenceNo'));
        }

        $catalogs = $query->latest()->paginate(15)->appends($request->query());

        // Dropdown values for filtering (unique list)
        $orderNos = ProductCatalog::where('item', 'Twill Tape')->distinct()->pluck('order_no');
        $merchandisers = ProductCatalog::where('item', 'Twill Tape')->distinct()->pluck('coordinator_name');
        $referenceNos = ProductCatalog::where('item', 'Twill Tape')->distinct()->pluck('reference_no');

        return view('production-catalog.pages.tapeCatalog', compact(
            'catalogs', 'orderNos', 'merchandisers', 'referenceNos'
        ));
    }

    /**
     * Display a listing of all product catalog entries
     */
    public function create(): View|Factory
    {
        return view('product-catalog.create');
    }

    /**
     * Common storing method for all catalog entries
     */
    public function store(Request $request): RedirectResponse
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
            'supplier' => 'nullable|string|max:255',
            'pst_no' => 'nullable|string|max:255',
        ]);

        ProductCatalog::create($request->all());

        return redirect()->route('product-catalog.index')->with('success', 'Catalog entry created.');
    }

    /**
     * Store method forcing item = Elastic
     */
    public function storeElastic(Request $request): RedirectResponse
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
            'supplier' => 'nullable|string|max:255',
            'pst_no' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['item'] = 'Elastic'; // force item

        ProductCatalog::create($data);

        return redirect()->route('elasticCatalog.index')->with('success', 'Elastic catalog entry created.');
    }

    /**
     * Store method forcing item = Elastic
     */
    public function storeCode(Request $request): RedirectResponse
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
            'supplier' => 'nullable|string|max:255',
            'pst_no' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['item'] = 'Cord'; // force item

        ProductCatalog::create($data);

        return redirect()->route('codeCatalog.index')->with('success', 'Cord catalog entry created.');
    }

    /**
     * Store method forcing item = Elastic
     */
    public function storeTape(Request $request): RedirectResponse
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
            'supplier' => 'nullable|string|max:255',
            'pst_no' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['item'] = 'Twill Tape'; // force item

        ProductCatalog::create($data);

        return redirect()->route('tapeCatalog.index')->with('success', 'Tape catalog entry created.');
    }

    /**
     * Upload order image for a specific catalog entry
     */
    public function uploadOrderImage(Request $request, ProductCatalog $catalog): RedirectResponse
    {
        $request->validate([
            'order_image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('order_image')) {
            // Delete old image if exists
            if ($catalog->order_image && Storage::disk('public')->exists('order_images/' . $catalog->order_image)) {
                Storage::disk('public')->delete('order_images/' . $catalog->order_image);
            }

            // Store a new image with reference_no as filename
            $file = $request->file('order_image');
            $extension = $file->getClientOriginalExtension();
            $safeReference = preg_replace('/[^A-Za-z0-9_\-]/', '_', $catalog->reference_no); // clean reference_no
            $filename = $safeReference . '.' . $extension;

            $file->storeAs('order_images', $filename, 'public');

            $catalog->order_image = $filename;
            $catalog->save();
        }

        return back()->with('success', 'Order image uploaded successfully.');
    }

    /**
     * Update approval details for a specific catalog entry
     */
    public function updateApproval(Request $request, ProductCatalog $productCatalog): RedirectResponse
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

            // Create a clean filename using reference_no
            $file = $request->file('approval_card');
            $extension = $file->getClientOriginalExtension();
            $safeReference = preg_replace('/[^A-Za-z0-9_\-]/', '_', $productCatalog->reference_no); // clean filename
            $filename = $safeReference . '.' . $extension;

            // Save a file with reference_no as name
            $path = $file->storeAs('approval_cards', $filename, 'public');

            $updateData['approval_card'] = $path;
            $updateData['is_approval_card_locked'] = true;
        }

        // Save updates if any
        if (!empty($updateData)) {
            $productCatalog->update($updateData);
        }

        return back()->with('success', 'Approval details updated successfully.');
    }

    /**
     * Show the form for editing the specified product catalog entry
     */
    public function edit(ProductCatalog $productCatalog): View|Factory
    {
        return view('product-catalog.edit', compact('productCatalog'));
    }

    /**
     * Update the specified product catalog entry
     */
    public function update(Request $request, ProductCatalog $productCatalog): RedirectResponse
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

    /**
     * Remove the specified product catalog entry from storage
     */
    public function destroy(ProductCatalog $productCatalog): RedirectResponse
    {
        $productCatalog->delete();

        return redirect()->route('product-catalog.index')->with('success', 'Catalog entry deleted.');
    }

    /**
     * Update shade for a specific catalog entry
     */
    public function updateShade(Request $request, ProductCatalog $catalog): RedirectResponse
    {
        $request->validate([
            'selected_shade' => 'required|string',
        ]);

        try {
            $catalog->shade = $request->input('selected_shade');
            $catalog->save();

            return redirect()->back()->with('success', 'Shade updated successfully.');
        } catch (Exception) {
            return redirect()->back()->with('error', 'Failed to update shade. Please try again.');
        }
    }

}

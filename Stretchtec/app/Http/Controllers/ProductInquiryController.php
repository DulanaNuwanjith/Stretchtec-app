<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use App\Models\ProductInquiry;
use App\Models\Stock;
use App\Models\Stores;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $samples = ProductCatalog::all();
        $productInquiries = ProductInquiry::Paginate(10);

        return view('production.pages.production-inquery-details', compact('samples', 'productInquiries'));
    }


    public function getSampleDetails($id): JsonResponse
    {
        $sample = ProductCatalog::findOrFail($id);

        return response()->json([
            'shade' => $sample->shade,
            'colour' => $sample->colour,
            'item' => $sample->item,
            'tkt' => $sample->tkt,
            'size' => $sample->size,
            'supplier' => $sample->supplier,
            'pst_no' => $sample->pst_no,
            'supplier_comments' => $sample->supplierComment,
        ]);
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
            // Common validation rules
            $rules = [
                'po_number' => 'required|string|max:255',
                'customer_name' => 'required|string|max:255',
                'merchandiser_name' => 'nullable|string|max:255',
                'customer_coordinator' => 'required|string|max:255',
                'customer_req_date' => 'required|date',
                'order_type' => 'required|string|in:sample,direct',
                'remarks' => 'nullable|string',
                'items' => 'required|array|min:1',

                // Item fields
                'items.*.shade' => 'required|string|max:255',
                'items.*.color' => 'required|string|max:255',
                'items.*.tkt' => 'required|string|max:255',
                'items.*.size' => 'required|string|max:255',
                'items.*.item' => 'required|string|max:255',
                'items.*.supplier' => 'nullable|string|max:255',
                'items.*.qty' => 'required|numeric|min:1',
                'items.*.uom' => 'required|string|max:50',
                'items.*.price' => 'required|numeric|min:0',
            ];

            // Sample orders must have sample_id
            if ($request->input('order_type') === 'sample') {
                $rules['items.*.sample_id'] = 'required|integer|exists:product_catalogs,id';
            } else {
                $rules['items.*.sample_id'] = 'nullable|integer';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            // Generate the next PO number
            $lastOrderNo = ProductInquiry::selectRaw("MAX(CAST(SUBSTRING(prod_order_no, 7) AS UNSIGNED)) as max_number")
                ->value('max_number');
            $nextNumber = $lastOrderNo ? $lastOrderNo + 1 : 1;
            $prodOrderNo = 'ST-PO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Save each item
            foreach ($data['items'] as $item) {
                $referenceNo = null;
                $sampleId = null;

                if (!empty($item['sample_id'])) {
                    // Sample order → fetch reference from catalog
                    $sample = ProductCatalog::find($item['sample_id']);
                    $referenceNo = $sample?->reference_no;
                    $sampleId = $item['sample_id'];
                } else {
                    // Direct order → use "Direct Bulk" or value from a hidden field
                    $referenceNo = $data['reference_no'] ?? 'Direct Bulk';
                }

                ProductInquiry::create([
                    'prod_order_no' => $prodOrderNo,
                    'po_received_date' => now(),
                    'po_number' => $data['po_number'],
                    'customer_name' => $data['customer_name'],
                    'merchandiser_name' => $data['merchandiser_name'] ?? null,
                    'customer_coordinator' => $data['customer_coordinator'],
                    'customer_req_date' => $data['customer_req_date'],
                    'order_type' => $data['order_type'],
                    'remarks' => $data['remarks'] ?? null,
                    'reference_no' => $referenceNo,
                    'sample_id' => $sampleId,
                    'shade' => $item['shade'],
                    'color' => $item['color'],
                    'tkt' => $item['tkt'],
                    'size' => $item['size'],
                    'item' => $item['item'],
                    'supplier' => $item['supplier'] ?? null,
                    'qty' => $item['qty'],
                    'uom' => $item['uom'],
                    'price' => $item['price'],
                ]);
            }

            return redirect()->back()->with('success', 'PO with multiple items created successfully.');

        } catch (Exception $e) {
            Log::error('Exception occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong.')->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(ProductInquiry $productInquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductInquiry $productInquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductInquiry $productInquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): ?RedirectResponse
    {
        try {
            $productInquiry = ProductInquiry::findOrFail($id);
            $productInquiry->delete();

            return redirect()->back()->with('success', 'Product Inquiry deleted successfully.');
        } catch (Exception $e) {
            Log::error('Product Inquiry Delete Error: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->back()->with('error', 'Failed to delete the product inquiry.');
        }
    }

    public function sendToStore($id)
    {
        try {
            // 1. Get production order
            $productionOrder = ProductInquiry::findOrFail($id);

            // 2. Find the item from the product catalog using reference_no
            $catalogItem = ProductCatalog::where('reference_no', $productionOrder->reference_no)->first();

            $storesItem = Stock::where('reference_no', $productionOrder->reference_no)->first();

            if (!$catalogItem) {
                return redirect()->back()->with('error', 'No item found in product catalog for this reference number.');
            }

            if (!$storesItem){
                return redirect()->back()->with('error', 'No item found in stores for this reference number.');
            }

            // 3. Create a new store record
            $store = new Stores();
            $store->order_no = $productionOrder->id;
            $store->prod_order_no = $productionOrder->prod_order_no;
            $store->reference_no = $productionOrder->reference_no;
            $store->shade = $catalogItem->shade ?? null;
            $store->qty_available = $storesItem->qty_available ?? 0;
            $store->qty_allocated = 0;
            $store->assigned_by = auth()->user()->name; // whoever assigns
            $store->is_qty_assigned = false;
            $store->save();

            return redirect()->back()->with('success', 'Order successfully sent to store.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error sending to store: ' . $e->getMessage());
        }
    }

}

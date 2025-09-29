<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use App\Models\ProductInquiry;
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
            // Step 1: Validate input
            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|string|max:255',
                'merchandiser_name' => 'required|string|max:255',
                'customer_coordinator' => 'required|string|max:255',
                'po_number' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                'item' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'supplier' => 'nullable|string|max:255',
                'pst_no' => 'nullable|string|max:255',
                'supplier_comment' => 'nullable|string',
                'sample_id' => 'required_if:order_type,sample|integer', // <-- only required if order_type is 'sample'
                'shade' => 'required|string|max:255',
                'tkt' => 'required|string|max:255',
                'qty' => 'required|numeric',
                'uom' => 'required|string|max:50',
                'price' => 'required|numeric',
                'customer_req_date' => 'nullable|date',
                'order_type' => 'required|string|max:255',
                'remarks' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Step 2: Build data
            $data = $validator->validated();

            if ($data['order_type'] === 'direct') {
                $data['reference_no'] = 'Direct Bulk';
                unset($data['sample_id']); // Not needed
            } else {
                $sample = ProductCatalog::findOrFail($data['sample_id']);
                $data['reference_no'] = $sample->reference_no;
            }


            // Generate automatic product order number
            $lastOrderNo = ProductInquiry::selectRaw("MAX(CAST(SUBSTRING(prod_order_no, 7) AS UNSIGNED)) as max_number")
                ->value('max_number');

            // increment
            $nextNumber = $lastOrderNo ? $lastOrderNo + 1 : 1;

            // Format: ST-PO-00001
            $data['prod_order_no'] = 'ST-PO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Set PO received date
            $data['po_received_date'] = now();

            // Step 3: Create a record
            ProductInquiry::create($data);

            return redirect()->back()->with('success', 'Product inquiry created successfully.');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please contact support.')
                ->withInput();
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

}

<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use App\Models\ProductInquiry;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $samples = ProductCatalog::all();

        return view('production.pages.production-inquery-details', compact('samples'));
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
        ]);
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
        try {
            // ✅ Step 1: Validate input
            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|string|max:255',
                'merchandiser_name' => 'required|string|max:255',
                'customer_coordinator' => 'required|string|max:255',
                'po_number' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                'item' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'reference_no' => 'required|string|max:255',
                'shade' => 'required|string|max:255',
                'tkt' => 'required|string|max:255',
                'qty' => 'required|numeric',
                'uom' => 'required|string|max:50',
                'price' => 'required|numeric',
                'customer_req_date' => 'required|date',
                'order_type' => 'required|string|max:255',
                'remarks' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::warning('Product Inquiry Validation Failed', [
                    'errors' => $validator->errors()->toArray(),
                    'input'  => $request->all()
                ]);

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // ✅ Step 2: Build data
            $data = $validator->validated();

            // Generate automatic product order number
            $lastOrder = ProductInquiry::orderBy('id', 'desc')->value('prod_order_no');
            if ($lastOrder) {
                $lastNumber = (int) str_replace('PO', '', $lastOrder);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }
            $data['prod_order_no'] = 'PO' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Set PO received date
            $data['po_received_date'] = now();

            // ✅ Step 3: Create record
            ProductInquiry::create($data);

            Log::info('Product inquiry created successfully', [
                'po_number' => $request->po_number,
                'customer'  => $request->customer_name,
            ]);

            return redirect()->back()->with('success', 'Product inquiry created successfully.');

        } catch (Exception $e) {
            Log::error('Unexpected error while creating Product Inquiry', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

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
    public function destroy(ProductInquiry $productInquiry)
    {
        //
    }
}

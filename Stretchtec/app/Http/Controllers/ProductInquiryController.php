<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use App\Models\ProductCatalog;
use App\Models\ProductInquiry;
use App\Models\ProductOrderPreperation;

class ProductInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $samples = ProductCatalog::all();
        $productInquiries = ProductInquiry::simplePaginate(10);

        return view('production.pages.production-inquery-details', compact('samples', 'productInquiries'));
    }

    /**
     * Get sample details for AJAX requests.
     */
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
     * Store a newly created product inquiry.
     */
    public function store(Request $request): ?RedirectResponse
    {
        try {
            // Validate input
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
                'reference_no' => 'required|string|max:255',
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
                Log::warning('Product Inquiry Validation Failed', [
                    'errors' => $validator->errors()->toArray(),
                    'input' => $request->all(),
                ]);

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $validator->validated();

            // Generate automatic product order number
            $lastOrderNo = ProductInquiry::selectRaw("MAX(CAST(SUBSTRING(prod_order_no, 4) AS UNSIGNED)) as max_number")
                ->value('max_number');
            $nextNumber = $lastOrderNo ? $lastOrderNo + 1 : 1;
            $data['prod_order_no'] = 'PO-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Set PO received date
            $data['po_received_date'] = now();

            // Create a record
            ProductInquiry::create($data);

            Log::info('Product inquiry created successfully', [
                'po_number' => $request->po_number,
                'customer' => $request->customer_name,
            ]);

            return redirect()->back()->with('success', 'Product inquiry created successfully.');
        } catch (Exception $e) {
            Log::error('Unexpected error while creating Product Inquiry', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Something went wrong. Please contact support.')
                ->withInput();
        }
    }

    /**
     * Delete a product inquiry.
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

    /**
     * Send a product inquiry to production.
     */
    public function sendToProduction($id): RedirectResponse
    {
        try {
            $productInquiry = ProductInquiry::findOrFail($id);

            if ($productInquiry->isSentToProduction) {
                return redirect()->back()->with('info', 'This inquiry has already been sent to production.');
            }

            // Update the inquiry status and timestamp
            $productInquiry->update([
                'isSentToProduction' => true,
                'status' => 'Sent to Production',
                'sentToProductionDate' => now(),
            ]);

            // Create a production order preparation record
            ProductOrderPreperation::create([
                'product_inquiry_id' => $productInquiry->id,
                'prod_order_no' => $productInquiry->prod_order_no,
                'customer_name' => $productInquiry->customer_name,
                'item' => $productInquiry->item,
                'size' => $productInquiry->size,
                'color' => $productInquiry->color,
                'shade' => $productInquiry->shade,
                'tkt' => $productInquiry->tkt,
                'qty' => $productInquiry->qty,
                'uom' => $productInquiry->uom,
                'supplier' => $productInquiry->supplier,
                'pst_no' => $productInquiry->pst_no,
                'supplier_comment' => $productInquiry->supplier_comment,
                'status' => 'Pending', // initial production status
            ]);

            return redirect()->back()->with('success', 'Inquiry sent to production successfully.');
        } catch (Exception $e) {
            Log::error('Send to Production Error: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->back()->with('error', 'Failed to send inquiry to production.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SampleInquiry;
use App\Models\SamplePreparationProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\SamplePreparationRnD;

class SampleInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SampleInquiry::query();

        // Apply filters
        if ($request->filled('customer')) {
            $query->where('customerName', $request->customer);
        }

        if ($request->filled('merchandiser')) {
            $query->where('merchandiseName', $request->merchandiser);
        }

        if ($request->filled('item')) {
            $query->where('item', $request->item);
        }

        // Filter by delivery status using customerDeliveryDate
        if ($request->filled('deliveryStatus')) {
            $validStatuses = ['Delivered', 'Pending'];

            if (in_array($request->deliveryStatus, $validStatuses)) {
                if ($request->deliveryStatus === 'Delivered') {
                    $query->whereNotNull('customerDeliveryDate');
                } elseif ($request->deliveryStatus === 'Pending') {
                    $query->whereNull('customerDeliveryDate');
                }
            }
        }

        // Filter by customer decision
        if ($request->filled('customerDecision')) {
            $query->where('customerDecision', $request->customerDecision);
        }

        $inquiries = $query->latest()->paginate(10);

        // Dynamic dropdown values
        $customers = SampleInquiry::select('customerName')->distinct()->orderBy('customerName')->pluck('customerName');
        $merchandisers = SampleInquiry::select('merchandiseName')->distinct()->orderBy('merchandiseName')->pluck('merchandiseName');
        $items = SampleInquiry::select('item')->distinct()->orderBy('item')->pluck('item');

        return view('sample-development.pages.sample-inquery-details', compact('inquiries', 'customers', 'merchandisers','items'));
    }

    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        $inquiry = SampleInquiry::findOrFail($id);
        $inquiry->notes = $request->notes;
        $inquiry->save();

        return redirect()->back()->with('success', 'Note updated successfully.');
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
            // ✅ Validate input (excluding orderNo)
            $validated = $request->validate([
                'order_file' => 'nullable|file|mimes:pdf,jpg,jpeg',
                'inquiry_date' => 'required|date',
                'customer' => 'required|string|max:255',
                'merchandiser' => 'required|string|max:255',
                'coordinator' => 'string|max:255',
                'item' => 'required|string|max:255',
                'style' => 'nullable|string|max:255',
                'ItemDiscription' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                'qtRef' => 'nullable|string|max:255',
                'colour' => 'required|string|max:255',
                'sample_quantity' => 'required|string|max:255',
                'customer_comments' => 'nullable|string',
                'customer_requested_date' => 'nullable|date',
            ]);

            // 🔢 Generate next unique order number safely
            $lastOrderNo = DB::table('sample_inquiries')
                ->selectRaw("MAX(CAST(SUBSTR(orderNo, 7) AS INTEGER)) as max_number")
                ->value('max_number');

            $nextNumber = $lastOrderNo ? $lastOrderNo + 1 : 1;
            $orderNo = 'ST-SD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // 📂 Handle file upload
            $orderFilePath = null;
            if ($request->hasFile('order_file')) {
                $date = now()->format('Ymd'); // e.g. 20250707
                $extension = $request->file('order_file')->getClientOriginalExtension();
                $fileName = $orderNo . '_' . $date . '.' . $extension;

                $orderFilePath = $request->file('order_file')->storeAs(
                    'order_files',
                    $fileName,
                    'public'
                );
            }

            // 📝 Create the record
            SampleInquiry::create([
                'orderFile' => $orderFilePath,
                'orderNo' => $orderNo,
                'inquiryReceiveDate' => $validated['inquiry_date'],
                'customerName' => $validated['customer'],
                'merchandiseName' => $validated['merchandiser'],
                'coordinatorName' => $validated['coordinator'],
                'item' => $validated['item'],
                'ItemDiscription' => $validated['ItemDiscription'],
                'size' => $validated['size'],
                'qtRef' => $validated['qtRef'],
                'color' => $validated['colour'],
                'style' => $validated['style'] ?? null,
                'sampleQty' => $validated['sample_quantity'],
                'customerSpecialComment' => $validated['customer_comments'] ?? null,
                'customerRequestDate' => $validated['customer_requested_date'] ?? null,
                'alreadyDeveloped' => false,
                'productionStatus' => 'Pending',
                'customerDecision' => 'Pending',
            ]);

            return redirect()->back()->with('success', 'Sample Inquiry Created Successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Sample Inquiry Store Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(SampleInquiry $sampleInquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SampleInquiry $sampleInquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SampleInquiry $sampleInquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SampleInquiry $sampleInquiry)
    {
        try {
            $sampleInquiry->delete(); // Use soft delete if enabled
            return redirect()->back()->with('success', 'Sample Inquiry deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Sample Inquiry Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete the inquiry.');
        }
    }


    public function updateDevelopedStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_inquiries,id',
            'alreadyDeveloped' => 'required|in:0,1',
        ]);

        $inquiry = SampleInquiry::findOrFail($request->id);
        $inquiry->alreadyDeveloped = $request->alreadyDeveloped;
        $inquiry->save();

        return back()->with('success', 'Development status updated!');
    }

    public function markSentToSampleDevelopment(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_inquiries,id',
        ]);

        $inquiry = SampleInquiry::findOrFail($request->id);

        // Set the timestamp to now
        $inquiry->sentToSampleDevelopmentDate = Carbon::now();
        $inquiry->save();

        if (!SamplePreparationRnD::where('sample_inquiry_id', $inquiry->id)->exists()) {
            SamplePreparationRnD::create([
                'sample_inquiry_id' => $inquiry->id,
                'orderNo' => $inquiry->orderNo,
                'customerRequestDate' => $inquiry->customerRequestDate,
            ]);
        }


        return back()->with('success', 'Marked as sent to sample development.');
    }

    public function markCustomerDelivered(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_inquiries,id',
            'delivered_qty' => 'required|integer|min:1',
        ]);

        $inquiry = SampleInquiry::findOrFail($request->id);

        if (!$inquiry->referenceNo) {
            return redirect()->back()->with('error', 'Reference No is required to deduct stock.');
        }

        $stock = \App\Models\SampleStock::where('reference_no', $inquiry->referenceNo)->first();

        if (!$stock) {
            return redirect()->back()->with('error', 'Sample Stock not found for the given reference number.');
        }

        $deliveredQty = (int) $request->delivered_qty;

        if ($deliveredQty > $stock->available_stock) {
            return redirect()->back()->with('error', 'Delivered quantity exceeds available stock.');
        }

        // Deduct stock
        $stock->available_stock -= $deliveredQty;
        if ($stock->available_stock == 0) {
            $stock->special_note = 'No more stock available';
        }
        $stock->save();

        // Mark delivery
        $inquiry->customerDeliveryDate = now();
        $inquiry->save();

        return redirect()->back()->with('success', 'Stock deducted and marked as delivered.');
    }


    public function updateDecision(Request $request, $id)
    {
        $request->validate([
            'customerDecision' => 'required|string|in:Pending,Order Received,Order Not Received,Order Rejected',
        ]);

        $sampleInquiry = SampleInquiry::findOrFail($id);
        $sampleInquiry->customerDecision = $request->input('customerDecision');
        $sampleInquiry->save();

        return redirect()->back()->with('success', 'Customer decision updated successfully.');
    }
}

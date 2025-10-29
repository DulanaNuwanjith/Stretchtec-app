<?php

namespace App\Http\Controllers;

use App\Models\MailBooking;
use App\Models\ProductCatalog;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MailBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $samples = ProductCatalog::where('isShadeSelected', true)->get();
        $mailBookings = MailBooking::orderBy('mail_booking_number', 'DESC')
            ->orderBy('order_received_date', 'DESC')
            ->paginate(10);

        return view('production.pages.mail-booking', compact('samples', 'mailBookings'));
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
                'email' => 'required|string|max:255',
                'customer_name' => 'required|string|max:255',
                'merchandiser_name' => 'nullable|string|max:255',
                'customer_coordinator' => 'required|string|max:255',
                'customer_req_date' => 'required|date',
                'remarks' => 'nullable|string',
                'items' => 'required|array|min:1',

                // Item fields
                'items.*.order_type' => 'required|string|in:sample,direct',
                'items.*.shade' => 'required|string|max:255',
                'items.*.color' => 'required|string|max:255',
                'items.*.tkt' => 'nullable|string|max:255',
                'items.*.size' => 'required|string|max:255',
                'items.*.item' => 'required|string|max:255',
                'items.*.supplier' => 'nullable|string|max:255',
                'items.*.qty' => 'required|numeric|min:1',
                'items.*.uom' => 'required|string|max:50',
                'items.*.unitPrice' => 'required|numeric|min:0',
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

            // Save each item separately with a unique order number
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

                // 👉 Generate unique prod_order_no per item
                $lastOrderNo = MailBooking::selectRaw("MAX(CAST(SUBSTRING(mail_booking_number, 7) AS UNSIGNED)) as max_number")
                    ->value('max_number');
                $nextNumber = $lastOrderNo ? $lastOrderNo + 1 : 1;
                $prodOrderNo = 'ST-MB-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                MailBooking::create([
                    'mail_booking_number' => $prodOrderNo,
                    'order_received_date' => now(),
                    'email' => $data['email'],
                    'customer_name' => $data['customer_name'],
                    'merchandiser_name' => $data['merchandiser_name'] ?? null,
                    'customer_coordinator' => $data['customer_coordinator'],
                    'customer_req_date' => $data['customer_req_date'],
                    'order_type' => $item['order_type'],
                    'remarks' => $data['remarks'] ?? null,
                    'reference_no' => $referenceNo,
                    'sample_id' => $sampleId,
                    'shade' => $item['shade'],
                    'color' => $item['color'],
                    'tkt' => $item['tkt'] ?? 'N/A',
                    'size' => $item['size'],
                    'item' => $item['item'],
                    'supplier' => $item['supplier'] ?? null,
                    'qty' => $item['qty'],
                    'uom' => $item['uom'],
                    'unitPrice' => $item['unitPrice'],
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
    public function show(MailBooking $mailBooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MailBooking $mailBooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MailBooking $mailBooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MailBooking $mailBooking)
    {
        //
    }
}

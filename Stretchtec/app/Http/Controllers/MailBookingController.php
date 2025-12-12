<?php

namespace App\Http\Controllers;

use App\Models\MailBooking;
use App\Models\ProductCatalog;
use App\Models\ProductInquiry;
use App\Models\ProductOrderPreperation;
use App\Models\Stock;
use App\Models\Stores;
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
    public function index(Request $request): Factory|View
    {
        $samples = ProductCatalog::where('isShadeSelected', true)->get();

        // Base query
        $query = MailBooking::query();

        // Apply filters
        if ($request->filled('mailBookingNo')) {
            $query->where('mail_booking_number', $request->input('mailBookingNo'));
        }

        if ($request->filled('referenceNo')) {
            $query->where('reference_no', $request->input('referenceNo'));
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }

        if ($request->filled('customer')) {
            $query->where('customer_name', $request->input('customer'));
        }

        if ($request->filled('merchandiser')) {
            $query->where('merchandiser_name', $request->input('merchandiser'));
        }

        if ($request->filled('coordinator')) {
            $coordinators = (array) $request->input('coordinator');
            $query->whereIn('customer_coordinator', $coordinators);
        }

        if ($request->filled('orderReceivedDate')) {
            $query->whereDate('order_received_date', $request->input('orderReceivedDate'));
        }

        $mailBookings = $query
            ->orderBy('mail_booking_number', 'DESC')
            ->orderBy('order_received_date', 'DESC')
            ->paginate(10)
            ->appends($request->query());

        // Dropdown source lists
        $mailBookingNos = MailBooking::orderBy('mail_booking_number', 'DESC')
            ->pluck('mail_booking_number')
            ->unique()
            ->values();

        $referenceNumbers = MailBooking::orderBy('reference_no')
            ->whereNotNull('reference_no')
            ->pluck('reference_no')
            ->unique()
            ->values();

        $emails = MailBooking::orderBy('email')
            ->whereNotNull('email')
            ->pluck('email')
            ->unique()
            ->values();

        $coordinators = MailBooking::orderBy('customer_coordinator')
            ->whereNotNull('customer_coordinator')
            ->pluck('customer_coordinator')
            ->unique()
            ->values();

        $customers = MailBooking::orderBy('customer_name')
            ->whereNotNull('customer_name')
            ->pluck('customer_name')
            ->unique()
            ->values();

        $merchandisers = MailBooking::orderBy('merchandiser_name')
            ->whereNotNull('merchandiser_name')
            ->pluck('merchandiser_name')
            ->unique()
            ->values();

        return view('production.pages.mail-booking', compact(
            'samples',
            'mailBookings',
            'mailBookingNos',
            'referenceNumbers',
            'emails',
            'coordinators',
            'customers',
            'merchandisers'
        ));
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
                'customer_req_date' => 'nullable|date',
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

    /**
     * Send a Mail Booking inquiry to production.
     */
    public function sendToProductionMail($id): RedirectResponse
    {
        try {
            $productInquiry = MailBooking::findOrFail($id);

            if ($productInquiry->isSentToProduction) {
                return redirect()->back()->with('info', 'This inquiry has already been sent to production.');
            }

            // Update the inquiry status and timestamp
            $productInquiry->update([
                'isSentToProduction' => true,
                'status' => 'Sent to Production',
                'sent_to_production_at' => now(),
            ]);

            // Create a production order preparation record
            ProductOrderPreperation::create([
                'product_inquiry_id' => $productInquiry->id,
                'prod_order_no' => $productInquiry->mail_booking_number,
                'customer_name' => $productInquiry->customer_name,
                'reference_no' => $productInquiry->reference_no,
                'item' => $productInquiry->item,
                'size' => $productInquiry->size,
                'color' => $productInquiry->color,
                'shade' => $productInquiry->shade,
                'tkt' => $productInquiry->tkt,
                'qty' => $productInquiry->qty - optional($productInquiry->stores)->sum(function ($store) {
                    return $store->qty_allocated ?? 0;
                }) ?? 0,
                'uom' => $productInquiry->uom,
                'supplier' => $productInquiry->supplier,
                'pst_no' => $productInquiry->pst_no,
                'supplier_comment' => $productInquiry->supplier_comment,
                'status' => 'Pending',
            ]);

            return redirect()->back()->with('success', 'Inquiry sent to production successfully.');
        } catch (Exception $e) {
            Log::error('Send to Production Error: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->back()->with('error', 'Failed to send inquiry to production.');
        }
    }

    public function sendToStoreMail($id): ?RedirectResponse
    {
        try {
            // 1. Get production order
            $productionOrder = MailBooking::findOrFail($id);

            // 2. Find the item from the product catalog using reference_no
            $catalogItem = ProductCatalog::where('reference_no', $productionOrder->reference_no)->first();

            $storesItem = Stock::where('reference_no', $productionOrder->reference_no)->first();

            $productionOrder->isSentToStock = true;
            $productionOrder->status = 'Sent to Store';

            if (!$catalogItem) {
                $productionOrder->canSendToProduction = true;
                $productionOrder->save();
                return redirect()->back()->with('success', 'This is a direct order send directly to the production');
            }

            if (!$storesItem) {
                $productionOrder->canSendToProduction = true;
                $productionOrder->save();
                return redirect()->back()->with('success', 'No Available Stock. Send Directly to Production');
            }

            $productionOrder->sent_to_stock_at = now();
            $productionOrder->save();

            // 3. Create a new store record
            $store = new Stores();
            $store->order_no = null;
            $store->mail_no = $productionOrder->id ?? null;
            $store->prod_order_no = null;
            $store->mail_booking_no = $productionOrder->mail_booking_number;
            $store->reference_no = $productionOrder->reference_no;
            $store->shade = $catalogItem->shade ?? null;
            $store->qty_available = $storesItem->qty_available ?? 0;
            $store->qty_allocated = 0;
            $store->assigned_by = auth()->user()->name;
            $store->is_qty_assigned = false;
            $store->save();

            return redirect()->back()->with('success', 'Order successfully sent to store.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error sending to store: ' . $e->getMessage());
        }
    }
}

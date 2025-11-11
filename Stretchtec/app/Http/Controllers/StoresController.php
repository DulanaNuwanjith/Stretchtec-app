<?php

namespace App\Http\Controllers;

use App\Models\MailBooking;
use App\Models\ProductInquiry;
use App\Models\SampleStock;
use App\Models\Stock;
use App\Models\Stores;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory
    {
        // Get search term if any
        $search = $request->input('search');

        // Query with optional search filter
        $query = SampleStock::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%$search%")
                    ->orWhere('shade', 'like', "%$search%")
                    ->orWhere('special_note', 'like', "%$search%");
            });
        }

        // Paginate results, e.g. 10 per page
        $sampleStocks = $query->orderBy('reference_no')->paginate(10);

        $sampleStocks->appends(['search' => $search]);

        return view('store-management.storeManagement', compact('sampleStocks', 'search'));

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
    public function store(Request $request): void
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Stores $stores): void
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stores $stores): void
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stores $stores): void
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stores $stores): void
    {
        //
    }

    public function assign(Request $request, $id): RedirectResponse
    {
        // Validate request
        $validated = $request->validate([
            'qty_allocated' => 'required|numeric|min:0',
            'allocated_uom' => 'required|string|in:meters,yards,pieces',
            'reason_for_reject' => 'nullable|string'
        ]);

        // Fetch the store record and related stock and order
        $store = Stores::findOrFail($id);
        $stock = Stock::where('reference_no', $store->reference_no)->firstOrFail();

        $requestedUom = $validated['allocated_uom'];

        /**
         * --------------------------------------------------------------------
         * Handle assignment based on the order type
         * --------------------------------------------------------------------
         */
        if (!is_null($store->order_no)) {
            // Case 1: Product Inquiry order
            $order = ProductInquiry::where('id', $store->order_no)->firstOrFail();
        } elseif (!is_null($store->mail_booking_no)) {
            // Case 2: Mail Booking order
            $order = MailBooking::where('id', $store->mail_no)->firstOrFail();
        } else {
            // No valid link
            return back()->withErrors(['order_type' => 'Store record is not linked to any valid order.']);
        }

        /**
         * --------------------------------------------------------------------
         * Step 1: Validate UOM consistency
         * --------------------------------------------------------------------
         */
        if ($order->uom !== $requestedUom) {
            return back()->withErrors([
                'allocated_uom' => "Allocated UOM must match the customer's requested UOM ({$order->uom})."
            ]);
        }

        /**
         * --------------------------------------------------------------------
         * Step 2: Convert allocated qty to yards for uniform stock deduction
         * --------------------------------------------------------------------
         */
        if ($requestedUom === 'meters') {
            $allocatedQtyInYards = $validated['qty_allocated'] * 1.09361;
        } elseif ($requestedUom === 'yards') {
            $allocatedQtyInYards = $validated['qty_allocated'];
        } elseif ($requestedUom === 'pieces') {
            if ($stock->uom !== 'pieces') {
                return back()->withErrors([
                    'qty_allocated' => 'Cannot allocate pieces from stock measured in ' . $stock->uom
                ]);
            }
            $allocatedQtyInYards = $validated['qty_allocated'];
        }

        /**
         * --------------------------------------------------------------------
         * Check allocated qty is less than or equal to the requested qty
         * --------------------------------------------------------------------
         */


        // If the store record is linked to a Mail Booking
        if ($store->mail_no !== null) {
            $mailBooking = MailBooking::find($store->mail_no);

            if (!$mailBooking) {
                return back()->withErrors([
                    'qty_allocated' => 'No related mail booking record found for this store record.',
                ]);
            }

            $requestedQty = $mailBooking->qty; // Assuming the MailBooking table has a `qty` field

        } elseif ($store->order_no !== null) {
            // Otherwise, check the Product Inquiry table
            $inquiry = ProductInquiry::find($store->order_no);

            if (!$inquiry) {
                return back()->withErrors([
                    'qty_allocated' => 'No related product inquiry found for this store record.',
                ]);
            }

            $requestedQty = $inquiry->qty;
        } else {
            // Neither mail_no nor order_no is set
            return back()->withErrors([
                'qty_allocated' => 'No valid linked record found for this store entry.',
            ]);
        }

        // Now compare the allocated qty with the requested qty
        if ($validated['qty_allocated'] > $requestedQty) {
            return back()->withErrors([
                'qty_allocated' => 'Allocated quantity (' . $validated['qty_allocated'] . ') cannot exceed the requested quantity (' . $requestedQty . ').',
            ]);
        }

        /**
         * --------------------------------------------------------------------
         * Step 3: Check and reduce stock
         * --------------------------------------------------------------------
         */
        if ($stock->qty_available < $allocatedQtyInYards) {
            return back()->withErrors([
                'qty_allocated' => 'Not enough stock available to allocate.'
            ]);
        }

        $stock->qty_available -= $allocatedQtyInYards;
        $stock->save();

        /**
         * --------------------------------------------------------------------
         * Step 4: Update store details
         * --------------------------------------------------------------------
         */
        $store->qty_allocated = $validated['qty_allocated'];
        $store->reason_for_reject = $validated['reason_for_reject'] ?? null;
        $store->is_qty_assigned = true;
        $store->assigned_by = auth()->user()->name ?? 'System';
        $store->allocated_uom = substr(strtolower($requestedUom), 0, 1);

        if ($store->qty_available >= $store->qty_allocated) {
            $store->qty_available -= $store->qty_allocated;
        } else {
            return back()->withErrors([
                'qty_allocated' => 'Allocated qty cannot exceed available qty.'
            ]);
        }

        $store->save();

        /**
         * --------------------------------------------------------------------
         * Step 5: Mark the respective order as ready for production but if requested qty is fulfilled then mark as status == ready for delivery
         * --------------------------------------------------------------------
         */
        if (!is_null($store->order_no)) {
            // Product Inquiry case
            $order->canSendToProduction = true;

            // Check if the full quantity is allocated
            if ($order->qty <= $store->qty_allocated) {
                $order->isSentToProduction = true;
                $order->status = 'Ready For Delivery';
            } else {
                $order->status = 'Ready for Production';
            }

            $order->save();
        } elseif (!is_null($store->mail_no)) {
            // Mail Booking case
            $order->canSendToProduction = true;
            $order->status = 'Ready for Production';
            $order->save();
        }

        return redirect()->back()->with('success', 'Quantity assigned successfully!');
    }
}

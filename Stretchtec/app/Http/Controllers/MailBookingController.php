<?php

namespace App\Http\Controllers;

use App\Models\MailBooking;
use App\Models\ProductCatalog;
use App\Models\ProductInquiry;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MailBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $samples = ProductCatalog::where('isShadeSelected', true)->get();
        $productInquiries = ProductInquiry::orderBy('prod_order_no', 'DESC')
            ->orderBy('po_received_date', 'DESC')
            ->paginate(10);

        return view('production.pages.mail-booking', compact('samples', 'productInquiries'));
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
        //
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

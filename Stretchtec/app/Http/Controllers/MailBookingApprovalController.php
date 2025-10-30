<?php

namespace App\Http\Controllers;

use App\Models\MailBooking;
use App\Models\MailBookingApproval;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MailBookingApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        // Fetch approvals with their related mail booking details
        $mailBookingApprovals = MailBookingApproval::with('mailBooking')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('production.pages.mail-booking-approval', compact('mailBookingApprovals'));
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
    public function store($id): RedirectResponse
    {
        //get the related mail booking record
        $mailBooking = MailBooking::findOrFail($id);

        //Update isSentForApproval field
        $mailBooking->isSentForApproval = true;
        $mailBooking->save();

        MailBookingApproval::create([
            'mail_booking_id' => $id,
        ]);

        return redirect()->back()->with('success', 'Sent For approval');
    }

    public function approve(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'remarks' => 'nullable|string|max:255',
        ]);

        $mailBookingApproval = MailBookingApproval::findOrFail($id);

        $mailBookingApproval->remarks = $request->input('remarks');
        $mailBookingApproval->save();

        $mailBooking = $mailBookingApproval->mailBooking;

        // Update the mail booking approval status
        $mailBooking->isApproved = true;
        $mailBooking->approved_by = auth()->user()->id; // Assuming you have user authentication
        $mailBooking->approved_at = now();
        $mailBooking->save();

        return redirect()->back()->with('success', 'Mail booking approved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MailBookingApproval $mailBookingApproval): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MailBookingApproval $mailBookingApproval): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MailBookingApproval $mailBookingApproval): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MailBookingApproval $mailBookingApproval): void
    {
        //
    }
}

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
    public function index(Request $request): Factory|View
    {
        // Base query with relation
        $query = MailBookingApproval::with('mailBooking');

        // Apply filters against related MailBooking fields
        if ($request->filled('mailBookingNo')) {
            $query->whereHas('mailBooking', function ($q) use ($request) {
                $q->where('mail_booking_number', $request->input('mailBookingNo'));
            });
        }

        if ($request->filled('referenceNo')) {
            $query->whereHas('mailBooking', function ($q) use ($request) {
                $q->where('reference_no', $request->input('referenceNo'));
            });
        }

        if ($request->filled('email')) {
            $query->whereHas('mailBooking', function ($q) use ($request) {
                $q->where('email', 'LIKE', '%' . $request->input('email') . '%');
            });
        }

        if ($request->filled('customer')) {
            $query->whereHas('mailBooking', function ($q) use ($request) {
                $q->where('customer_name', $request->input('customer'));
            });
        }

        if ($request->filled('merchandiser')) {
            $query->whereHas('mailBooking', function ($q) use ($request) {
                $q->where('merchandiser_name', $request->input('merchandiser'));
            });
        }

        if ($request->filled('coordinator')) {
            $coordinators = (array) $request->input('coordinator');
            $query->whereHas('mailBooking', function ($q) use ($coordinators) {
                $q->whereIn('customer_coordinator', $coordinators);
            });
        }

        $mailBookingApprovals = $query
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->appends($request->query());

        // Dropdown source lists from MailBooking
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

        return view('production.pages.mail-booking-approval', compact(
            'mailBookingApprovals',
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
    public function store($id): RedirectResponse
    {
        //get the related mail booking record
        $mailBooking = MailBooking::findOrFail($id);

        //Update isSentForApproval field
        $mailBooking->isSentForApproval = true;
        $mailBooking->status = 'Sent For Approval';
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
        $mailBooking->status = 'Approved';
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

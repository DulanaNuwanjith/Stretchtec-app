<?php

namespace App\Http\Controllers;

use App\Models\ColorMatchReject;
use Illuminate\Http\Request;

class ColorMatchRejectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'id' => 'required|integer',
            'rejectReason' => 'required|string|max:500',
        ]);

        // Find the SamplePreparationRnD record using the provided ID
        $sampleInquiry = \App\Models\SamplePreparationRnD::with('sampleInquiry') // eager load if relation exists
        ->find($request->id);

        if (!$sampleInquiry) {
            return redirect()->back()
                ->withErrors(['id' => 'Sample Inquiry not found for the provided ID.']);
        }

        // Get orderNo from related SampleInquiry (if relationship exists)
        $orderNo = $sampleInquiry->orderNo ?? $sampleInquiry->sampleInquiry->orderNo;

        // Prepare data for insert
        $data = [
            'orderNo' => $orderNo,
            'rejectReason' => $request->rejectReason,
            'sentDate' => $sampleInquiry->colourMatchSentDate,
            'receiveDate' => $sampleInquiry->colourMatchReceiveDate,
            'rejectDate' => now(),
        ];

        ColorMatchReject::create($data);

        // Reset fields
        $sampleInquiry->colourMatchSentDate = null;
        $sampleInquiry->colourMatchReceiveDate = null;
        $sampleInquiry->save();

        return redirect()->back()->with('success', 'Color match reject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ColorMatchReject $colorMatchReject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ColorMatchReject $colorMatchReject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ColorMatchReject $colorMatchReject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ColorMatchReject $colorMatchReject)
    {
        //
    }
}

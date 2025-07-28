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
            'orderNo' => 'required|string|max:255',
            'rejectReason' => 'required|string|max:500',
        ]);

        //Get the sent_date and receive_date from the sample preparation R&D
        $sampleInquiry = \App\Models\SamplePreparationRnD::where('orderNo', $request->orderNo)->first();
        if (!$sampleInquiry) {
            return redirect()->back()->withErrors(['orderNo' => 'Sample Inquiry not found for the provided order number.']);
        }
        $request->merge([
            'sentDate' => $sampleInquiry->colourMatchSentDate,
            'receiveDate' => $sampleInquiry->colourMatchReceiveDate,
            'rejectDate' => now(), // Set the reject date to the current time
        ]);

        ColorMatchReject::create($request->all());

        return response()->json(['message' => 'Color match reject created successfully.'], 201);
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

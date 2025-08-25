<?php

namespace App\Http\Controllers;

use App\Models\ColorMatchReject;
use App\Models\SamplePreparationRnD;
use Illuminate\Http\Request;

class ColorMatchRejectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getRejectDetails($id)
    {
        $sample = SamplePreparationRnD::with('sampleInquiry')->find($id);

        if (!$sample) {
            return response()->json(['success' => false, 'message' => 'Sample not found.']);
        }

        // Get all rejects for this orderNo, sorted by rejectDate
        $rejects = ColorMatchReject::where('orderNo', $sample->orderNo)
            ->orderBy('rejectDate', 'desc')
            ->get()
            ->map(function ($reject) {
                return [
                    'sentDate' => optional($reject->sentDate)->format('Y-m-d H:i'),
                    'receiveDate' => optional($reject->receiveDate)->format('Y-m-d H:i'),
                    'rejectDate' => optional($reject->rejectDate)->format('Y-m-d H:i'),
                    'rejectReason' => $reject->rejectReason,
                ];
            });

        if ($rejects->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No reject records found.']);
        }

        return response()->json([
            'success' => true,
            'orderNo' => $sample->orderNo,
            'rejects' => $rejects,
        ]);
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
        $sampleInquiry = SamplePreparationRnD::with('sampleInquiry') // eager load if relation exists
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

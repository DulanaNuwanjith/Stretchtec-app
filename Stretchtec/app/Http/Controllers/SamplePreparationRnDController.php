<?php

namespace App\Http\Controllers;

use App\Models\SamplePreparationRnD;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SamplePreparationRnDController extends Controller
{
    public function viewRnD()
    {
        $samplePreparations = SamplePreparationRnD::with('sampleInquiry')->latest()->get();
        return view('sample-development.pages.sample-preparation-details', compact('samplePreparations'));
    }

    public function markColourMatchSent(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->colourMatchSentDate = Carbon::now();
        $rnd->save();

        return back()->with('success', 'Colour Match marked as sent.');
    }

    public function markColourMatchReceive(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->colourMatchReceiveDate = Carbon::now();
        $rnd->save();

        return back()->with('success', 'Colour Match marked as received.');
    }

    public function markYarnOrdered(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->yarnOrderedDate = Carbon::now();
        $rnd->save();

        return back()->with('success', 'Yarn Ordered Date marked.');
    }

    public function markYarnReceived(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->yarnReceiveDate = Carbon::now();
        $rnd->save();

        return back()->with('success', 'Yarn Receive Date marked.');
    }

    public function markSendToProduction(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->sendOrderToProductionStatus = Carbon::now(); // Store date/time
        $rnd->save();

        return back()->with('success', 'Order sent to production.');
    }

    public function setDevelopPlanDate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'developPlannedDate' => 'required|date',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);

        if (!$prep->developPlannedDate) {
            $prep->developPlannedDate = $request->developPlannedDate;
            $prep->is_dev_plan_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Develop Plan Date saved.');
    }


    // public function update(Request $request, $id)
    // {
    //     $prep = SamplePreparationRnd::findOrFail($id);

    //     if (!$prep->is_dev_plan_locked && $request->filled('developPlannedDate')) {
    //         $prep->developPlannedDate = $request->input('developPlannedDate');
    //         $prep->is_dev_plan_locked = true;
    //     }

    //     if (!$prep->is_po_locked && $request->filled('yarnOrderedPONumber')) {
    //         $prep->yarnOrderedPONumber = $request->input('yarnOrderedPONumber');
    //         $prep->is_po_locked = true;
    //     }

    //     if (!$prep->is_shade_locked && $request->filled('shade')) {
    //         $prep->shade = $request->input('shade');
    //         $prep->is_shade_locked = true;
    //     }

    //     if (!$prep->is_qty_locked && $request->filled('yarnOrderedQty')) {
    //         $prep->yarnOrderedQty = $request->input('yarnOrderedQty');
    //         $prep->is_qty_locked = true;
    //     }

    //     if (!$prep->is_tkt_locked && $request->filled('tkt')) {
    //         $prep->tkt = $request->input('tkt');
    //         $prep->is_tkt_locked = true;
    //     }

    //     if (!$prep->is_supplier_locked && $request->filled('yarnSupplier')) {
    //         $prep->yarnSupplier = $request->input('yarnSupplier');
    //         $prep->is_supplier_locked = true;
    //     }

    //     if (!$prep->is_deadline_locked && $request->filled('productionDeadline')) {
    //         $prep->productionDeadline = $request->input('productionDeadline');
    //         $prep->is_deadline_locked = true;
    //     }

    //     if (!$prep->is_reference_locked && $request->filled('referenceNo')) {
    //         $prep->referenceNo = $request->input('referenceNo');
    //         $prep->is_reference_locked = true;
    //     }

    //     // Save all changes
    //     $prep->save();

    //     return redirect()->back()->with('success', 'Sample Preparation updated.');
    // }


}

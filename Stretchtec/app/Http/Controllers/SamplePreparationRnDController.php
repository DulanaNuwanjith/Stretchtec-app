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

        if ($prep->developPlannedDate) {
            return back()->with('error', 'Development Plan Date is already set and locked.');
        }

        $prep->developPlannedDate = $request->developPlannedDate;
        $prep->is_dev_plan_locked = true;
        $prep->save();

        return back()->with('success', 'Develop Plan Date saved.');
    }


    public function lockPoField(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnOrderedPONumber' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        if (!$prep->is_po_locked) {
            $prep->yarnOrderedPONumber = $request->yarnOrderedPONumber;
            $prep->is_po_locked = true;
            $prep->save();
        }

        return back()->with('success', 'PO Number saved.');
    }

    public function lockShadeField(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'shade' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        if (!$prep->is_shade_locked) {
            $prep->shade = $request->shade;
            $prep->is_shade_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Shade saved.');
    }

    public function lockQtyField(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnOrderedQty' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        if (!$prep->is_qty_locked) {
            $prep->yarnOrderedQty = $request->yarnOrderedQty;
            $prep->is_qty_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Yarn Quantity saved.');
    }

    public function lockTktField(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'tkt' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        if (!$prep->is_tkt_locked) {
            $prep->tkt = $request->tkt;
            $prep->is_tkt_locked = true;
            $prep->save();
        }

        return back()->with('success', 'TKT saved.');
    }

    public function lockSupplierField(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnSupplier' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        if (!$prep->is_supplier_locked) {
            $prep->yarnSupplier = $request->yarnSupplier;
            $prep->is_supplier_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Supplier saved.');
    }

    public function lockDeadlineField(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'productionDeadline' => 'required|date',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        if (!$prep->is_deadline_locked) {
            $prep->productionDeadline = $request->productionDeadline;
            $prep->is_deadline_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Production Deadline saved.');
    }

    public function lockReferenceField(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'referenceNo' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);

        if (!$prep->is_reference_locked) {
            $prep->referenceNo = $request->referenceNo;
            $prep->is_reference_locked = true;
            $prep->save();

            // Sync with SampleInquiry
            $inquiry = $prep->sampleInquiry;
            if ($inquiry) {
                $inquiry->referenceNo = $prep->referenceNo;
                $inquiry->save();
            }
        }

        return back()->with('success', 'Reference No saved.');
    }


}

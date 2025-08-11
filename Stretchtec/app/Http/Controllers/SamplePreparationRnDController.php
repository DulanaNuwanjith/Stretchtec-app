<?php

namespace App\Http\Controllers;

use App\Models\ColorMatchReject;
use App\Models\LeftoverYarn;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationRnD;
use App\Models\SamplePreparationProduction;
use App\Models\SampleStock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SamplePreparationRnDController extends Controller
{
    public function viewRnD(Request $request)
    {
        $query = SamplePreparationRnD::with('sampleInquiry');

        // Filters
        if ($request->filled('order_no')) {
            $query->where('orderNo', $request->order_no);
        }

        if ($request->filled('po_no')) {
            $query->where('yarnOrderedPONumber', $request->po_no);
        }

        if ($request->filled('shade')) {
            $query->where('shade', $request->shade);
        }

        if ($request->filled('reference_no')) {
            $query->where('referenceNo', $request->reference_no);
        }

        // FILTER DATE FIELDS USING snake_case input names AND camelCase columns
        if ($request->filled('customer_requested_date')) {
            $query->whereDate('customerRequestDate', $request->customer_requested_date);
        }

        if ($request->filled('development_plan_date')) {
            $query->whereDate('developPlannedDate', $request->development_plan_date);
        }

        // Pagination or just all?
        $samplePreparations = $query
            ->orderByRaw('CASE WHEN referenceNo IS NULL THEN 0 ELSE 1 END ASC')  // NULL referenceNo first
            ->orderBy('customerRequestDate', 'asc')                            // nearest upcoming date first
            ->orderByDesc('id')                                                 // fallback to latest entries
            ->paginate(10);

        // Dynamic values for dropdowns
        $orderNos = SamplePreparationRnD::whereNotNull('orderNo')->where('orderNo', '!=', '')->distinct()->orderBy('orderNo')->pluck('orderNo');
        $poNos = SamplePreparationRnD::whereNotNull('yarnOrderedPONumber')->where('yarnOrderedPONumber', '!=', '')->distinct()->orderBy('yarnOrderedPONumber')->pluck('yarnOrderedPONumber');
        $shades = SamplePreparationRnD::whereNotNull('shade')->where('shade', '!=', '')->distinct()->orderBy('shade')->pluck('shade');
        $references = SamplePreparationRnD::whereNotNull('referenceNo')->where('referenceNo', '!=', '')->distinct()->orderBy('referenceNo')->pluck('referenceNo');

        // ✅ Add this to pass SampleStock reference list
        $sampleStockReferences = SampleStock::pluck('reference_no')->unique();

        return view('sample-development.pages.sample-preparation-details', compact(
            'samplePreparations',
            'orderNos',
            'poNos',
            'shades',
            'references',
            'sampleStockReferences'
        ));
    }

    public function markColourMatchSent(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->colourMatchSentDate = Carbon::now();
        $rnd->productionStatus = 'Colour Match Sent'; // Update production status
        $rnd->save();

        $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
        if ($sampleInquiry) {
            $sampleInquiry->productionStatus = 'Colour Match Sent'; // Update production status in SampleInquiry
            $sampleInquiry->save();
        }

        return back()->with('success', 'Colour Match marked as sent.');
    }

    public function markColourMatchReceive(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->colourMatchReceiveDate = Carbon::now();
        $rnd->productionStatus = 'Colour Match Received'; // Update production status
        $rnd->save();

        $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
        if ($sampleInquiry) {
            $sampleInquiry->productionStatus = 'Colour Match Received'; // Update production status in SampleInquiry
            $sampleInquiry->save();
        }

        return back()->with('success', 'Colour Match marked as received.');
    }

    public function markYarnOrdered(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnOrderedPONumber' => 'required|string',
            'value'=> 'required|numeric',
            'shade' => 'required|string',
            'tkt' => 'required|string',
            'yarnPrice' => 'required|string',
            'yarnSupplier' => 'required|string',
            'customSupplier' => 'nullable|string',
        ]);

        if ($request->customSupplier) {
            $request->yarnSupplier = $request->customSupplier;
        }

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->yarnOrderedDate = Carbon::now();
        $rnd->yarnOrderedPONumber = $request->yarnOrderedPONumber;
        $rnd->yarnOrderedWeight = $request->value;
        $rnd->shade = $request->shade;
        $rnd->tkt = $request->tkt;
        $rnd->yarnPrice = $request->yarnPrice;
        $rnd->yarnSupplier = $request->yarnSupplier;
        $rnd->is_po_locked = true; // Lock the PO field
        $rnd->is_shade_locked = true; // Lock the shade field
        $rnd->is_tkt_locked = true; // Lock the TKT field
        $rnd->is_supplier_locked = true; // Lock the supplier field
        $rnd->productionStatus = 'Yarn Ordered';
        $rnd->save();

        $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
        if ($sampleInquiry) {
            $sampleInquiry->productionStatus = 'Yarn Ordered'; // Update production status in SampleInquiry
            $sampleInquiry->save();
        }

        return back()->with('success', 'Yarn Ordered Date marked.');
    }

    public function markYarnReceived(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->yarnReceiveDate = Carbon::now();
        $rnd->productionStatus = 'Yarn Received'; // Update production status
        $rnd->save();

        $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
        if ($sampleInquiry) {
            $sampleInquiry->productionStatus = 'Yarn Received'; // Update production status in SampleInquiry
            $sampleInquiry->save();
        }

        return back()->with('success', 'Yarn Receive Date marked.');
    }

    public function markSendToProduction(Request $request)
    {
        $rnd = SamplePreparationRnD::findOrFail($request->id);

        // Optional: Check if already sent
        if ($rnd->sendOrderToProductionStatus) {
            return redirect()->back()->with('info', 'Already sent to production.');
        }

        // Update sendOrderToProductionStatus
        $rnd->sendOrderToProductionStatus = now();
        $rnd->productionStatus = 'Sent to Production'; // Update production status
        $rnd->save();

        $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
        if ($sampleInquiry) {
            $sampleInquiry->productionStatus = 'Sent to Production'; // Update production status in SampleInquiry
            $sampleInquiry->save();
        }

        // Create production record
        SamplePreparationProduction::create([
            'sample_preparation_rnd_id' => $rnd->id,
            'order_no' => $rnd->orderNo,
            'production_deadline' => $rnd->productionDeadline,
            'order_received_at' => now(),
        ]);

        return back()->with('success', 'Sent to production successfully.');
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

        // ✅ Skip duplicate check if alreadyDeveloped === 'No Need to Develop'
        if ($prep->alreadyDeveloped !== 'No Need to Develop') {
            if (SampleStock::where('reference_no', $request->referenceNo)->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['referenceNo' => 'This Reference Number is already in use. Please enter a unique one.']);
            }
        }

        if (!$prep->is_reference_locked) {
            $prep->referenceNo = $request->referenceNo;
            $prep->is_reference_locked = true;
            $prep->save();

            // ✅ Fetch production details safely
            $production = $prep->production;
            $productionOutput = (int)($production->production_output ?? 0);
            $damagedOutput = (int)($production->damaged_output ?? 0);
            $availableStock = max($productionOutput - $damagedOutput, 0);

            // ✅ Only create SampleStock if availableStock > 0
            if ($availableStock > 0) {
                SampleStock::create([
                    'reference_no' => $request->referenceNo,
                    'shade' => $prep->shade ?? $prep->sampleInquiry?->shade ?? 'N/A',
                    'available_stock' => $availableStock,
                    'special_note' => null,
                ]);
            }

            // ✅ Sync with SampleInquiry
            $inquiry = $prep->sampleInquiry;
            if ($inquiry) {
                $inquiry->referenceNo = $prep->referenceNo;
                $inquiry->save();
            }
        }

        return back()->with('success', 'Reference No saved and Sample Stock created.');
    }

    public function updateDevelopedStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'alreadyDeveloped' => 'required|string',
            'shade' => 'nullable|string',
            'tkt' => 'nullable|string',
            'yarnSupplier' => 'nullable|string',
            'value' => 'nullable|numeric',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);

        // Disallow update if locked (you can adjust this condition if locking rules differ)
        if ($prep->alreadyDeveloped || $prep->developPlannedDate) {
            return back()->with('error', 'Status is locked and cannot be changed.');
        }

        // Always update alreadyDeveloped
        $prep->alreadyDeveloped = $request->alreadyDeveloped;

        // Only update extra fields when Tape Match Pan Asia
        if ($request->alreadyDeveloped === 'Tape Match Pan Asia') {
            $prep->shade = $request->shade;
            $prep->tkt = $request->tkt;
            $prep->yarnSupplier = $request->yarnSupplier;
            $prep->yarnOrderedWeight = $request->value;
            $prep->productionStatus = 'Tape Match';

            $sampleInquiry = SampleInquiry::where('orderNo', $prep->orderNo)->first();
            if ($sampleInquiry) {
                $sampleInquiry->productionStatus = 'Tape Match'; // Update production status in SampleInquiry
                $sampleInquiry->save();
            }

            // Lock related fields
            $prep->is_shade_locked = true;
            $prep->is_tkt_locked = true;
            $prep->is_supplier_locked = true;
            $prep->is_yarn_ordered_weight_locked = true;
        }

        if ($request->alreadyDeveloped === 'No Need to Develop'){
            $prep->productionStatus = 'No Development';

            $sampleInquiry = SampleInquiry::where('orderNo', $prep->orderNo)->first();
            if ($sampleInquiry) {
                $sampleInquiry->productionStatus = 'No Development'; // Update production status in SampleInquiry
                $sampleInquiry->save();
            }

        }

        $prep->save();

        return back()->with('success', 'Developed status updated successfully!');
    }


    public function updateYarnWeights(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'field' => 'required|in:yarnOrderedWeight,yarnLeftoverWeight',
            'value' => 'required|numeric|min:0',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        $field = $request->field;
        $lockField = 'is_' . Str::snake($field) . '_locked';

        $prep->$field = $request->value;
        $prep->$lockField = true;
        $prep->save();

        // ✅ Insert into leftover_yarns if yarnLeftoverWeight is updated
        if ($field === 'yarnLeftoverWeight') {
            LeftoverYarn::create([
                'shade'              => $prep->shade,
                'po_number'          => $prep->yarnOrderedPONumber,
                'yarn_received_date' => \Carbon\Carbon::parse($prep->yarnReceiveDate)->format('Y-m-d'),
                'tkt'                => $prep->tkt,
                'yarn_supplier'      => $prep->yarnSupplier,
                'available_stock'    => $request->value, // using yarnLeftoverWeight as available_stock
            ]);
        }

        return back()->with('success', 'Weight updated and leftover recorded.');
    }

    public function borrow(Request $request, $id)
    {
        $request->validate([
            'borrow_qty' => 'required|integer|min:1',
        ]);

        $leftover = LeftoverYarn::findOrFail($id);
        $borrowQty = $request->borrow_qty;

        if ($borrowQty > $leftover->available_stock) {
            return back()->with('error', 'Borrowed quantity exceeds available stock.');
        }

        if ($borrowQty == $leftover->available_stock) {
            $leftover->delete();
            return back()->with('success', 'All yarn borrowed. Record deleted.');
        }

        $leftover->available_stock -= $borrowQty;
        $leftover->save();

        return back()->with('success', 'Borrowed successfully.');
    }

}

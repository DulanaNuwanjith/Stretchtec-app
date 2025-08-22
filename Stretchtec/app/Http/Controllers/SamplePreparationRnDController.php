<?php

namespace App\Http\Controllers;

use App\Models\ColorMatchReject;
use App\Models\LeftoverYarn;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationRnD;
use App\Models\SamplePreparationProduction;
use App\Models\SampleStock;
use App\Models\ShadeOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SamplePreparationRnDController extends Controller
{
    public function viewRnD(Request $request)
    {
        // Eager load sampleInquiry and shadeOrders
        $query = SamplePreparationRnD::with(['sampleInquiry', 'shadeOrders']);

        // Filters
        if ($request->filled('order_no')) {
            $query->where('orderNo', $request->order_no);
        }

        if ($request->filled('po_no')) {
            $query->where('yarnOrderedPONumber', $request->po_no);
        }

        if ($request->filled('shade')) {
            // Filter by shade_orders table if needed
            $query->whereHas('shadeOrders', function($q) use ($request) {
                $q->where('shade', $request->shade);
            });
        }

        if ($request->filled('reference_no')) {
            $query->where('referenceNo', $request->reference_no);
        }

        if ($request->filled('customer_requested_date')) {
            $query->whereDate('customerRequestDate', $request->customer_requested_date);
        }

        if ($request->filled('development_plan_date')) {
            $query->whereDate('developPlannedDate', $request->development_plan_date);
        }

        if ($request->filled('coordinator_name')) {
            $query->whereHas('sampleInquiry', function($q) use ($request) {
                $q->where('coordinatorName', $request->coordinator_name);
            });
        }

        $samplePreparations = $query
            ->orderByRaw("CASE WHEN productionStatus = 'Order Delivered' THEN 1 ELSE 0 END ASC")
            ->orderByDesc('id')
            ->paginate(10);

        // Dropdown dynamic values
        $orderNos = SamplePreparationRnD::whereNotNull('orderNo')->where('orderNo', '!=', '')->distinct()->orderBy('orderNo')->pluck('orderNo');
        $poNos = SamplePreparationRnD::whereNotNull('yarnOrderedPONumber')->where('yarnOrderedPONumber', '!=', '')->distinct()->orderBy('yarnOrderedPONumber')->pluck('yarnOrderedPONumber');
        $shades = SamplePreparationRnD::whereNotNull('shade')->where('shade', '!=', '')->distinct()->orderBy('shade')->pluck('shade');
        $references = SamplePreparationRnD::whereNotNull('referenceNo')->where('referenceNo', '!=', '')->distinct()->orderBy('referenceNo')->pluck('referenceNo');
        $coordinators = SampleInquiry::whereNotNull('coordinatorName')->where('coordinatorName', '!=', '')->distinct()->orderBy('coordinatorName')->pluck('coordinatorName');
        $sampleStockReferences = SampleStock::pluck('reference_no')->unique();

        // Production dispatch check
        $dispatchCheck = SamplePreparationProduction::all();

        return view('sample-development.pages.sample-preparation-details', compact(
            'samplePreparations',
            'orderNos',
            'poNos',
            'shades',
            'references',
            'sampleStockReferences',
            'coordinators',
            'dispatchCheck'
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
        // Validate the request
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnOrderedPONumber' => 'nullable|string',
            'value' => 'nullable|numeric',
            'shades' => 'nullable|array', // Accept array of shades
            'shades.*' => 'nullable|string', // Each shade as string
            'tkt' => 'nullable|string',
            'yarnPrice' => 'nullable|string',
            'yarnSupplier' => 'required|string',
            'customSupplier' => 'nullable|string',
        ]);

        // Determine supplier
        $yarnSupplier = $request->customSupplier ?: $request->yarnSupplier;

        // Find the RnD record
        $rnd = SamplePreparationRnD::findOrFail($request->id);
        $rnd->yarnOrderedDate = Carbon::now();
        $rnd->yarnOrderedPONumber = $request->yarnOrderedPONumber;
        $rnd->yarnOrderedWeight = $request->value;
        $rnd->tkt = $request->tkt;
        $rnd->yarnPrice = $request->yarnPrice;
        $rnd->yarnSupplier = $yarnSupplier;

        // Lock fields after submission
        $rnd->is_po_locked = true;
        $rnd->is_shade_locked = true;
        $rnd->is_tkt_locked = true;
        $rnd->is_supplier_locked = true;

        $rnd->productionStatus = 'Yarn Ordered';
        $rnd->save();

        // Handle shades
        if ($request->shades && count($request->shades) > 0) {
            // Delete old shade records if any
            $rnd->shadeOrders()->delete();

            // Insert new shade records into shade_orders table
            foreach ($request->shades as $shade) {
                $rnd->shadeOrders()->create([
                    'shade' => $shade,
                    'status' => 'Pending',
                ]);
            }

            // Update RnD shade column with comma-separated values
            $rnd->shade = implode(', ', $request->shades);
            $rnd->save();
        }

        // Update SampleInquiry status if exists
        $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
        if ($sampleInquiry) {
            $sampleInquiry->productionStatus = 'Yarn Ordered';
            $sampleInquiry->save();
        }

        return back()->with('success', 'Yarn Ordered Date and shades marked successfully.');
    }

    public function markYarnReceived(Request $request)
    {
        $request->validate([
            'rnd_id' => 'required|exists:sample_preparation_rnd,id',
            'shade_ids' => 'required|array|min:1',
            'shade_ids.*' => 'exists:shade_orders,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->rnd_id);

        $newPstNumbers = []; // For RnD aggregated column

        foreach ($request->shade_ids as $shadeId) {
            $shade = ShadeOrder::findOrFail($shadeId);

            // Only process PST if RnD supplier is Pan Asia
            if (trim(strtolower($rnd->yarnSupplier)) === 'pan asia') {
                $pstNoInput = $request->pst_no[$shadeId] ?? null;

                if ($pstNoInput) {
                    // Clean input, multiple comma-separated values allowed
                    $pstNumbers = array_map(function($num) {
                        $num = preg_replace('/\D/', '', $num); // keep only digits
                        return 'PA/ST-' . str_pad($num, 5, '0', STR_PAD_LEFT);
                    }, explode(',', $pstNoInput));

                    // Append to RnD aggregated column
                    $newPstNumbers = array_merge($newPstNumbers, $pstNumbers);

                    // Save to shade_orders table (per shade)
                    $existingShadePst = $shade->pst_no ? explode(',', $shade->pst_no) : [];
                    $shade->pst_no = implode(',', array_merge($existingShadePst, $pstNumbers));
                }
            }

            $shade->status = 'Yarn Received';
            $shade->yarn_receive_date = now();
            $shade->save();
        }

        // Append aggregated PST to RnD column
        if (!empty($newPstNumbers)) {
            $existingPst = $rnd->pst_no ? explode(',', $rnd->pst_no) : [];
            $rnd->pst_no = implode(',', array_merge($existingPst, $newPstNumbers));
        }

        // Update production status
        $totalShades = $rnd->shadeOrders()->count();
        $receivedCount = $rnd->shadeOrders()->where('status', 'Yarn Received')->count();

        if ($receivedCount === $totalShades) {
            $rnd->productionStatus = 'Yarn Received';
        } elseif ($receivedCount > 0) {
            $rnd->productionStatus = 'Yarn Received*'; // partial
        }

        $rnd->yarnReceiveDate = now();
        $rnd->save();

        // Sync with SampleInquiry
        $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
        if ($sampleInquiry) {
            $sampleInquiry->productionStatus = $rnd->productionStatus;
            $sampleInquiry->save();
        }

        return back()->with('success', 'Yarn receipt and PST numbers updated successfully.');
    }

    public function markSendToProduction(Request $request)
    {
        $request->validate([
            'rnd_id' => 'required|exists:sample_preparation_rnd,id',
            'shade_ids' => 'required|array|min:1',
            'shade_ids.*' => 'exists:shade_orders,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->rnd_id);

        // Update selected shades to "Sent to Production"
        ShadeOrder::whereIn('id', $request->shade_ids)->update([
            'status' => 'Sent to Production',
        ]);

        // 🔹 Ensure only ONE production record per order_no
        $production = SamplePreparationProduction::firstOrNew([
            'sample_preparation_rnd_id' => $rnd->id,
            'order_no' => $rnd->orderNo,
        ]);

        // If it's a new record, set initial fields
        if (!$production->exists) {
            $production->production_deadline = $rnd->productionDeadline;
            $production->order_received_at = now();
        }

        // Save or update existing record
        $production->save();

        // Check if all shades are sent
        $pendingCount = $rnd->shadeOrders()->where('status', 'Pending')->count();

        if ($pendingCount === 0) {
            // Fully sent
            $rnd->productionStatus = 'Sent to Production';
            $rnd->sendOrderToProductionStatus = now();
            $rnd->save();

            // Update SampleInquiry
            $sampleInquiry = SampleInquiry::where('orderNo', $rnd->orderNo)->first();
            if ($sampleInquiry) {
                $sampleInquiry->productionStatus = 'Sent to Production';
                $sampleInquiry->save();
            }
        } else {
            // Partially sent
            $rnd->productionStatus = 'Sent to Production*'; // distinguish partial
            $rnd->save();
        }

        return back()->with('success', 'Selected shades sent to production successfully.');
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
        $isFirstTime = !$prep->is_reference_locked;

        // Lock reference if first time
        if ($isFirstTime) {
            $prep->referenceNo = $request->referenceNo;
            $prep->is_reference_locked = true;
            $prep->save();
        }

        // Fetch shades dispatched to RnD but not yet in stock
        $dispatchedShades = $prep->shadeOrders
            ->where('status', 'Dispatched to RnD')
            ->filter(fn($shade) => !SampleStock::where('reference_no', $prep->referenceNo)
                ->where('shade', $shade->shade)
                ->exists());

        foreach ($dispatchedShades as $shadeOrder) {
            $productionOutput = (int)($shadeOrder->production_output ?? 0);
            $damagedOutput = (int)($shadeOrder->damaged_output ?? 0);
            $availableStock = max($productionOutput - $damagedOutput, 0);

            if ($availableStock > 0) {
                SampleStock::create([
                    'reference_no' => $prep->referenceNo,
                    'shade' => $shadeOrder->shade,
                    'available_stock' => $availableStock,
                    'special_note' => null,
                ]);
            }
        }

        // Sync reference to SampleInquiry
        $inquiry = $prep->sampleInquiry;
        if ($inquiry) {
            $inquiry->referenceNo = $prep->referenceNo;
            $inquiry->save();
        }

        return back()->with('success', $isFirstTime
            ? 'Reference No saved and Sample Stock(s) created for dispatched shades.'
            : 'New dispatched shades added to Sample Stock.');
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
            'value' => 'required',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->id);
        $field = $request->field;
        $lockField = 'is_' . Str::snake($field) . '_locked';

        // If yarnLeftoverWeight and multiple shades -> array values expected
        if ($field === 'yarnLeftoverWeight' && str_contains($prep->shade, ',')) {
            $shadeList = array_map('trim', explode(',', $prep->shade));

            // Ensure $values is always an array
            $values = is_array($request->value) ? $request->value : explode(',', (string) $request->value);

            foreach ($shadeList as $index => $shade) {
                $weight = isset($values[$index]) ? (float)$values[$index] : 0;

                LeftoverYarn::create([
                    'shade'              => $shade,
                    'po_number'          => $prep->yarnOrderedPONumber,
                    'yarn_received_date' => \Carbon\Carbon::parse($prep->yarnReceiveDate)->format('Y-m-d'),
                    'tkt'                => $prep->tkt,
                    'yarn_supplier'      => $prep->yarnSupplier,
                    'available_stock'    => $weight, // always numeric
                ]);
            }

            // Store as comma-separated for reference
            $prep->$field = implode(',', $values);
        } else {
            // Single shade scenario: enforce numeric value
            $weight = is_array($request->value) ? (float)($request->value[0] ?? 0) : (float)$request->value;
            $prep->$field = $weight;

            if ($field === 'yarnLeftoverWeight') {
                LeftoverYarn::create([
                    'shade'              => $prep->shade,
                    'po_number'          => $prep->yarnOrderedPONumber,
                    'yarn_received_date' => \Carbon\Carbon::parse($prep->yarnReceiveDate)->format('Y-m-d'),
                    'tkt'                => $prep->tkt,
                    'yarn_supplier'      => $prep->yarnSupplier,
                    'available_stock'    => $weight, // always numeric
                ]);
            }
        }

        $prep->$lockField = true;
        $prep->save();

        return back()->with('success', 'Yarn weights updated successfully.');
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

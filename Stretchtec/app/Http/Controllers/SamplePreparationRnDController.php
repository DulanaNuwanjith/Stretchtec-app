<?php

namespace App\Http\Controllers;

use App\Models\LeftoverYarn;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationProduction;
use App\Models\SamplePreparationRnD;
use App\Models\SampleStock;
use App\Models\ShadeOrder;
use App\Models\ProductCatalog;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\View\View;

class SamplePreparationRnDController extends Controller
{
    /**
     * Display a listing of the Sample Preparation RnD records with filters and pagination.
     */
    public function viewRnD(Request $request): View|Factory
    {
        // Eager load sampleInquiry and shadeOrders
        $query = SamplePreparationRnD::with(['sampleInquiry', 'shadeOrders']);

        // Filters
        if ($request->filled('order_no')) {
            $query->where('orderNo', $request->input('order_no'));
        }

        if ($request->filled('po_no')) {
            $query->where('yarnOrderedPONumber', $request->input('po_no'));
        }

        if ($request->filled('shade')) {
            // Filter by the shade_orders table if needed
            $query->whereHas('shadeOrders', function ($q) use ($request) {
                $q->where('shade', $request->input('shade'));
            });
        }

        if ($request->filled('reference_no')) {
            $query->where('referenceNo', $request->input('reference_no'));
        }

        if ($request->filled('customer_requested_date')) {
            $query->whereDate('customerRequestDate', $request->input('customer_requested_date'));
        }

        if ($request->filled('development_plan_date')) {
            $query->whereDate('developPlannedDate', $request->input('development_plan_date'));
        }

        if ($request->filled('coordinator_name')) {
            $query->whereHas('sampleInquiry', function ($q) use ($request) {
                $q->where('coordinatorName', $request->input('coordinator_name'));
            });
        }

        $samplePreparations = $query
            ->orderByRaw("CASE WHEN productionStatus = 'Order Delivered' THEN 1 ELSE 0 END ASC")
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Dropdown dynamic values
        $orderNos = SamplePreparationRnD::whereNotNull('orderNo')->where('orderNo', '!=', '')->distinct()->orderBy('orderNo')->pluck('orderNo');
        $poNos = SamplePreparationRnD::whereNotNull('yarnOrderedPONumber')->where('yarnOrderedPONumber', '!=', '')->distinct()->orderBy('yarnOrderedPONumber')->pluck('yarnOrderedPONumber');
        $shades = SamplePreparationRnD::whereNotNull('shade')
            ->where('shade', '!=', '')
            ->pluck('shade')
            ->flatMap(function ($shade) {
                return collect(explode(',', $shade))->map(fn($s) => trim($s));
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();
        $references = SamplePreparationRnD::whereNotNull('referenceNo')->where('referenceNo', '!=', '')->distinct()->orderBy('referenceNo')->pluck('referenceNo');
        $coordinators = SampleInquiry::whereNotNull('coordinatorName')->where('coordinatorName', '!=', '')->distinct()->orderBy('coordinatorName')->pluck('coordinatorName');
        $sampleStockReferences = SampleStock::pluck('reference_no')->unique();

        // ✅ build reference → shades map
        $referenceShadesMap = SampleStock::select('reference_no', 'shade')
            ->get()
            ->groupBy('reference_no')
            ->map(fn($items) => $items->pluck('shade')->unique()->values())
            ->toArray();


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
            'dispatchCheck',
            'referenceShadesMap',
        ));
    }

    /**
     * Mark Colour Match as Sent or Received and update production status accordingly.
     */
    public function markColourMatchSent(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->input('id'));
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


    /**
     * Mark Colour Match as Received and update production status accordingly.
     */
    public function markColourMatchReceive(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->input('id'));
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


    /**
     * Mark Yarn as Ordered along with shades and update production status.
     */
    public function markYarnOrdered(Request $request): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnOrderedPONumber' => 'nullable|string',
            'value' => 'nullable|numeric',
            'shades' => 'nullable|array', // Accept array of shades
            'shades.*' => 'nullable|string', // Each shade as a string
            'comment' => 'nullable|string',
            'tkt' => 'nullable|string',
            'yarnPrice' => 'nullable|string',
            'yarnSupplier' => 'required|string',
            'customSupplier' => 'nullable|string',
        ]);

        // Determine supplier
        $yarnSupplier = $request->input('customSupplier') ?: $request->input('yarnSupplier');

        // Find the RnD record
        $rnd = SamplePreparationRnD::findOrFail($request->input('id'));
        $rnd->yarnOrderedDate = Carbon::now();
        $rnd->yarnOrderedPONumber = $request->input('yarnOrderedPONumber');
        $rnd->yarnOrderedWeight = $request->input('value');
        $rnd->tkt = $request->input('tkt');
        $rnd->yarnPrice = $request->input('yarnPrice');
        $rnd->yarnSupplier = $yarnSupplier;
        $rnd->supplierComment = $request->input('comment');

        // Lock fields after submission
        $rnd->is_po_locked = true;
        $rnd->is_shade_locked = true;
        $rnd->is_tkt_locked = true;
        $rnd->is_supplier_locked = true;

        $rnd->productionStatus = 'Yarn Ordered';
        $rnd->save();

        // Handle shades
        if ($request->input('shades') && count($request->input('shades')) > 0) {
            // Delete old shade records if any
            $rnd->shadeOrders()->delete();

            // Insert new shade records into the shade_orders table
            foreach ($request->input('shades') as $shade) {
                $rnd->shadeOrders()->create([
                    'shade' => $shade,
                    'status' => 'Pending',
                ]);
            }

            // Update the RnD shade column with comma-separated values
            $rnd->shade = implode(', ', $request->input('shades'));
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


    /**
     * Mark Yarn as Received along with PST numbers and update production status.
     */
    public function markYarnReceived(Request $request): RedirectResponse
    {
        $request->validate([
            'rnd_id' => 'required|exists:sample_preparation_rnd,id',
            'shade_ids' => 'required|array|min:1',
            'shade_ids.*' => 'exists:shade_orders,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->input('rnd_id'));

        $newPstNumbers = []; // For RnD aggregated column

        foreach ($request->input('shade_ids') as $shadeId) {
            $shade = ShadeOrder::findOrFail($shadeId);

            // Only process PST if RnD supplier is Pan Asia
            if (strtolower(trim($rnd->yarnSupplier)) === 'pan asia') {
                $pstNoInput = $request->pst_no[$shadeId] ?? null;

                if ($pstNoInput) {
                    // Clean input, multiple comma-separated values allowed
                    $pstNumbers = array_map(static function ($num) {
                        $num = preg_replace('/\D/', '', $num); // keep only digits
                        return 'PA/ST-' . str_pad($num, 5, '0', STR_PAD_LEFT);
                    }, explode(',', $pstNoInput));

                    // Append to RnD aggregated column
                    array_push($newPstNumbers, ...$pstNumbers);

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
            array_push($existingPst, ...$newPstNumbers);
            $rnd->pst_no = implode(',', $existingPst);
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


    /**
     * Mark selected shades as Sent to Production and update statuses accordingly.
     */
    public function markSendToProduction(Request $request): RedirectResponse
    {
        $request->validate([
            'rnd_id' => 'required|exists:sample_preparation_rnd,id',
            'shade_ids' => 'required|array|min:1',
            'shade_ids.*' => 'exists:shade_orders,id',
        ]);

        $rnd = SamplePreparationRnD::findOrFail($request->input('rnd_id'));

        // Update selected shades to "Sent to Production"
        ShadeOrder::whereIn('id', $request->input('shade_ids'))->update([
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
            $rnd->productionStatus = 'Sent to Production*';
            $rnd->save();
        }

        return back()->with('success', 'Selected shades sent to production successfully.');
    }


    /**
     * Set and lock the Development Plan Date for a Sample Preparation RnD record.
     */
    public function setDevelopPlanDate(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'developPlannedDate' => 'required|date',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));

        if ($prep->developPlannedDate) {
            return back()->with('error', 'Development Plan Date is already set and locked.');
        }

        $prep->developPlannedDate = $request->input('developPlannedDate');
        $prep->is_dev_plan_locked = true;
        $prep->save();

        return back()->with('success', 'Develop Plan Date saved.');
    }


    /**
     * Lock the PO Number field to prevent further edits when yarn ordered PO Number is added
     */
    public function lockPoField(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnOrderedPONumber' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));
        if (!$prep->is_po_locked) {
            $prep->yarnOrderedPONumber = $request->input('yarnOrderedPONumber');
            $prep->is_po_locked = true;
            $prep->save();
        }

        return back()->with('success', 'PO Number saved.');
    }


    /**
     * Lock the Shade field to prevent further edits when shades are added
     */
    public function lockShadeField(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'shade' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));
        if (!$prep->is_shade_locked) {
            $prep->shade = $request->input('shade');
            $prep->is_shade_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Shade saved.');
    }


    /**
     * Lock the TKT field to prevent further edits when TKT is added
     */
    public function lockTktField(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'tkt' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));
        if (!$prep->is_tkt_locked) {
            $prep->tkt = $request->input('tkt');
            $prep->is_tkt_locked = true;
            $prep->save();
        }

        return back()->with('success', 'TKT saved.');
    }


    /**
     * Lock the Supplier field to prevent further edits when Supplier is added
     */
    public function lockSupplierField(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'yarnSupplier' => 'required|string',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));
        if (!$prep->is_supplier_locked) {
            $prep->yarnSupplier = $request->input('yarnSupplier');
            $prep->is_supplier_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Supplier saved.');
    }


    /**
     * Lock the Yarn Ordered Weight field to prevent further edits when weight is added
     */
    public function lockDeadlineField(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'productionDeadline' => 'required|date',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));
        if (!$prep->is_deadline_locked) {
            $prep->productionDeadline = $request->input('productionDeadline');
            $prep->is_deadline_locked = true;
            $prep->save();
        }

        return back()->with('success', 'Production Deadline saved.');
    }


    /**
     * Lock the Reference No field, create Sample Stock for dispatched shades, and sync with Sample Inquiry
     */
    public function lockReferenceField(Request $request): RedirectResponse
    {
        $prep = SamplePreparationRnD::findOrFail($request->input('id'));

        // --- Dynamic validation ---
        if (in_array($prep->alreadyDeveloped, ['Need to Develop', 'Tape Match Pan Asia'])) {
            $request->validate([
                'id' => 'required|exists:sample_preparation_rnd,id',
                'referenceNo' => 'required|string',
            ]);
            $referenceNos = [$request->input('referenceNo')];
            $shades = [];
        } else {
            $request->validate([
                'id' => 'required|exists:sample_preparation_rnd,id',
                'referenceNo' => 'required|array',
                'referenceNo.*' => 'string',
                'shade' => 'nullable|array',
                'shade.*' => 'string',
                'yarnPrice' => 'required|numeric|min:0',
            ]);
            $referenceNos = $request->input('referenceNo');
            $shades = $request->input('shade', []);
            $prep->yarnPrice = $request->input('yarnPrice');
        }

        foreach ($referenceNos as $ref) {
            // --- Check if reference exists with same key details ---
            $existing = ProductCatalog::where('reference_no', $ref)
                ->where('item', $prep->sampleInquiry?->item)
                ->where('size', $prep->sampleInquiry?->size)
                ->where('shade', $prep->shade)
                ->where('supplier', $prep->yarnSupplier)
                ->where('pst_no', $prep->pst_no)
                ->first();

            if ($existing) {
                // ✅ Reference exists with same details → allow saving but do NOT create new
                continue;
            }

            // --- Check if reference exists with different details ---
            $conflict = ProductCatalog::where('reference_no', $ref)->first();
            if ($conflict) {
                // ❌ Reference exists but details mismatch → block
                return back()->withErrors([
                    'referenceNo' => "Reference '{$ref}' exists but details mismatch in Product Catalog."
                ])->withInput();
            }

            // --- Reference does not exist → create new ProductCatalog ---
            if ($prep->sampleInquiry) {
                ProductCatalog::create([
                    'order_no' => $prep->sampleInquiry->orderNo,
                    'reference_no' => $ref,
                    'reference_added_date' => now(),
                    'coordinator_name' => $prep->sampleInquiry->coordinatorName,
                    'item' => $prep->sampleInquiry->item,
                    'size' => $prep->sampleInquiry->size,
                    'colour' => $prep->sampleInquiry->color,
                    'shade' => $prep->shade,
                    'supplierComment' => $prep->supplierComment ?? null,
                    'tkt' => $prep->tkt ?? null,
                    'sample_inquiry_id' => $prep->sampleInquiry->id,
                    'sample_preparation_rnd_id' => $prep->id,
                    'supplier' => $prep->yarnSupplier,
                    'pst_no' => $prep->pst_no,
                    'isShadeSelected' => !empty($prep->shade) && strpos($prep->shade, ',') === false,
                ]);
            }
        }

        $isFirstTime = !$prep->is_reference_locked;

        // --- Set final reference ---
        if ($prep->alreadyDeveloped === 'No Need to Develop') {
            $pairs = collect($referenceNos)
                ->zip($shades)
                ->map(fn($pair) => trim($pair[0]) . (!empty($pair[1]) ? '|' . trim($pair[1]) : ''))
                ->implode(', ');
            $finalReference = $pairs;
        } else {
            $finalReference = $referenceNos[0] ?? null;
        }

        $prep->referenceNo = $finalReference;
        if ($isFirstTime) $prep->is_reference_locked = true;
        $prep->save();

        // --- Handle sample stock creation ---
        $dispatchedShades = $prep->shadeOrders
            ->where('status', 'Dispatched to RnD')
            ->filter(fn($shade) => !SampleStock::where('reference_no', $prep->referenceNo)
                ->where('shade', $shade->shade)
                ->exists());

        foreach ($dispatchedShades as $shadeOrder) {
            $availableStock = max((int)$shadeOrder->production_output - (int)$shadeOrder->damaged_output, 0);
            if ($availableStock > 0) {
                SampleStock::create([
                    'reference_no' => $prep->referenceNo,
                    'shade' => $shadeOrder->shade,
                    'available_stock' => $availableStock,
                    'special_note' => null,
                ]);
            }
        }

        // --- Sync reference to SampleInquiry ---
        if ($prep->sampleInquiry) {
            $prep->sampleInquiry->referenceNo = $prep->referenceNo;
            $prep->sampleInquiry->save();
        }

        return back()->with('success', $isFirstTime
            ? 'Reference No(s) saved and Sample Stock(s) created for dispatched shades.'
            : 'Reference No(s) updated and new dispatched shades added to Sample Stock.');
    }


    /**
     * Update the Developed Status and related fields, locking them as necessary.
     */
    public function updateDevelopedStatus(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'alreadyDeveloped' => 'required|string',
            'shade' => 'nullable|string',
            'comment' => 'nullable|string',
            'tkt' => 'nullable|string',
            'yarnSupplier' => 'nullable|string',
            'value' => 'nullable|numeric',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));

        // Disallow update if locked (you can adjust this condition if locking rules differ)
        if ($prep->alreadyDeveloped || $prep->developPlannedDate) {
            return back()->with('error', 'Status is locked and cannot be changed.');
        }

        // Always update alreadyDeveloped
        $prep->alreadyDeveloped = $request->input('alreadyDeveloped');

        // Only update extra fields when Tape Match Pan Asia
        if ($request->input('alreadyDeveloped') === 'Tape Match Pan Asia') {
            $prep->shade = $request->input('shade');
            $prep->tkt = $request->input('tkt');
            $prep->supplierComment = $request->input('comment');
            $prep->yarnSupplier = $request->input('yarnSupplier');
            $prep->yarnOrderedWeight = $request->input('value');
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

        if ($request->input('alreadyDeveloped') === 'No Need to Develop') {
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


    /**
     * Update yarn weights (ordered or leftover) and create LeftoverYarn records as needed.
     */
    public function updateYarnWeights(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_rnd,id',
            'field' => 'required|in:yarnOrderedWeight,yarnLeftoverWeight',
            'value' => 'required',
        ]);

        $prep = SamplePreparationRnD::findOrFail($request->input('id'));
        $field = $request->input('field');
        $lockField = 'is_' . Str::snake($field) . '_locked';

        // If yarnLeftoverWeight and multiple shades -> array values expected
        if ($field === 'yarnLeftoverWeight' && str_contains($prep->shade, ',')) {
            $shadeList = array_map('trim', explode(',', $prep->shade));

            // Ensure $values is always an array
            $values = is_array($request->input('value')) ? $request->input('value') : explode(',', (string)$request->input('value'));

            foreach ($shadeList as $index => $shade) {
                $weight = isset($values[$index]) ? (float)$values[$index] : 0;

                // Get pst_no from related shadeOrders for this shade
                $pstNo = $prep->shadeOrders()
                    ->where('shade', $shade)
                    ->pluck('pst_no')
                    ->unique()
                    ->implode(', ');

                if (empty($pstNo)) {
                    $pstNo = '-';
                }

                LeftoverYarn::create([
                    'shade' => $shade,
                    'po_number' => $prep->yarnOrderedPONumber,
                    'yarn_received_date' => Carbon::parse($prep->yarnReceiveDate)->format('Y-m-d'),
                    'tkt' => $prep->tkt,
                    'yarn_supplier' => $prep->yarnSupplier,
                    'available_stock' => $weight, // always numeric
                    'pst_no' => $pstNo,
                ]);
            }

            // Store as comma-separated for reference
            $prep->$field = implode(',', $values);
        } else {
            // Single shade scenario: enforce numeric value
            $weight = is_array($request->input('value')) ? (float)($request->value[0] ?? 0) : (float)$request->input('value');
            $prep->$field = $weight;

            if ($field === 'yarnLeftoverWeight') {
                // Get pst_no from related shadeOrders for this single shade
                $pstNo = $prep->shadeOrders()
                    ->where('shade', $prep->shade)
                    ->pluck('pst_no')
                    ->unique()
                    ->implode(', ');

                if (empty($pstNo)) {
                    $pstNo = '-';
                }

                LeftoverYarn::create([
                    'shade' => $prep->shade,
                    'po_number' => $prep->yarnOrderedPONumber,
                    'yarn_received_date' => Carbon::parse($prep->yarnReceiveDate)->format('Y-m-d'),
                    'tkt' => $prep->tkt,
                    'yarn_supplier' => $prep->yarnSupplier,
                    'available_stock' => $weight, // always numeric
                    'pst_no' => $pstNo,
                ]);
            }
        }

        $prep->$lockField = true;
        $prep->save();

        return back()->with('success', 'Yarn weights updated successfully.');
    }


    /**
     * Handle borrowing of leftover yarn, updating stock or deleting record as needed.
     */
    public function borrow(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'borrow_qty' => 'required|integer|min:1',
        ]);

        $leftover = LeftoverYarn::findOrFail($id);
        $borrowQty = $request->input('borrow_qty');

        if ($borrowQty > $leftover->available_stock) {
            return back()->with('error', 'Borrowed quantity exceeds available stock.');
        }

        if ($borrowQty === $leftover->available_stock) {
            $leftover->delete();
            return back()->with('success', 'All yarn borrowed. Record deleted.');
        }

        $leftover->available_stock -= $borrowQty;
        $leftover->save();

        return back()->with('success', 'Borrowed successfully.');
    }

    public function cancelOrder(Request $request, $id)
    {
        try {
            $prep = SamplePreparationRnd::findOrFail($id);

            // Update order_cancel to 1
            $prep->order_cancel = 1;
            $prep->save();

            // Return JSON response
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Optional: log the error
            \Log::error('Order Cancel Error: ' . $e->getMessage());

            // Return failure response
            return response()->json(['success' => false], 500);
        }
    }
}

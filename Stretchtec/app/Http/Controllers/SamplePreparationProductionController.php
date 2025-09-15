<?php

namespace App\Http\Controllers;

use App\Models\OperatorsandSupervisors;
use App\Models\SamplePreparationProduction;
use App\Models\ShadeOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Factory;
use Illuminate\View\View;

class SamplePreparationProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory|RedirectResponse
    {
        $operators = OperatorsandSupervisors::where('role', 'OPERATOR')->get();
        $supervisors = OperatorsandSupervisors::where('role', 'SUPERVISOR')->get();

        $productionsQuery = SamplePreparationProduction::with([
            'samplePreparationRnD.sampleInquiry',
            'samplePreparationRnD.shadeOrders'
        ])
            ->select('sample_preparation_production.*')
            ->addSelect([
                'all_dispatched' => DB::table('shade_orders')
                    ->selectRaw("CASE WHEN COUNT(*) > 0
                              AND COUNT(CASE WHEN status IN ('Dispatched to RnD', 'Delivered') THEN 1 END) = COUNT(*)
                              THEN 1 ELSE 0 END")
                    ->whereColumn('sample_preparation_rnd_id', 'sample_preparation_production.sample_preparation_rnd_id')
            ])
            ->orderByRaw('all_dispatched ASC') // not all dispatched = 0 → top, all dispatched = 1 → bottom
            ->orderByRaw('dispatch_to_rnd_at IS NULL DESC') // dispatched rows first
            ->orderBy('production_deadline')         // nearest upcoming deadline first
            ->latest();
        // fallback to newest created

        // Tab 3 Filters
        if ($request->input('tab') === '3' && $request->filled('tab')) {
            if ($request->filled('order_no')) {
                $productionsQuery->where('order_no', $request->input('order_no'));
            }

            if ($request->filled('development_plan_date')) {
                $productionsQuery->whereDate('production_deadline', $request->input('development_plan_date'));
            }
        }

        // Apply pagination and keep filters in links
        $productions = $productionsQuery
            ->paginate(10)
            ->withQueryString();

        // For Order No dropdown
        $orderNosTab3 = SamplePreparationProduction::select('order_no')
            ->distinct()
            ->orderBy('order_no')
            ->pluck('order_no');

        return view('sample-development.pages.sample-preparation-production', compact(
            'productions', 'operators', 'supervisors', 'orderNosTab3'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_production,id',
            'operator_name' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($request->input('id'));

        $production->update([
            'operator_name' => $request->input('operator_name'),
            'supervisor_name' => $request->input('supervisor_name'),
            'production_deadline' => $request->input('production_deadline'),
        ]);

        return redirect()->back()->with('success', 'Production record updated successfully.');
    }


    /**
     * Mark selected shades as In Production and update related statuses.
     */
    public function markOrderStart(Request $request): RedirectResponse
    {
        $request->validate([
            'production_id' => 'required|exists:sample_preparation_production,id',
            'shade_ids' => 'required|array|min:1',
            'shade_ids.*' => 'exists:shade_orders,id',
        ]);

        try {
            $production = SamplePreparationProduction::findOrFail($request->input('production_id'));
            $rnd = $production->samplePreparationRnD;

            if (!$rnd) {
                return back()->with('error', 'No related RnD record found.');
            }

            // Update selected shades to In Production
            ShadeOrder::whereIn('id', $request->input('shade_ids'))->update([
                'status' => 'In Production',
            ]);

            // Set the start time if not already set
            if (!$production->order_start_at) {
                $production->order_start_at = now();
                $production->save();
            }

            // Check if all related shades are In Production
            $remaining = $rnd->shadeOrders()->where('status', 'Sent to Production')->count();

            if ($remaining === 0) {
                // All shades are in production, update main statuses
                $rnd->productionStatus = 'In Production';
                $rnd->save();

                $inquiry = $rnd->sampleInquiry;
                if ($inquiry) {
                    $inquiry->productionStatus = 'In Production';
                    $inquiry->save();
                }
            }

            return back()->with('success', 'Selected shades marked as In Production.');
        } catch (Exception $e) {
            Log::error('Error in markOrderStart: ' . $e->getMessage());
            return back()->with('error', 'Failed to mark order start. Please try again.');
        }
    }


    /**
     * Mark a specific shade as Production Complete and update related statuses.
     */
    public function markOrderComplete(Request $request): RedirectResponse
    {
        $request->validate([
            'shade_id' => 'required|exists:shade_orders,id',
        ]);

        $shade = ShadeOrder::findOrFail($request->input('shade_id'));
        $shade->status = 'Production Complete';
        $shade->production_complete_date = Carbon::now();
        $shade->save();

        // Check if ALL shades of this RnD are completed
        $rnd = $shade->samplePreparationRnd;
        if ($rnd) {
            $allComplete = $rnd->shadeOrders->every(fn($s) => $s->status === 'Production Complete');

            if ($allComplete) {
                $rnd->productionStatus = 'Production Complete';
                $rnd->save();

                $sampleInquiry = $rnd->sampleInquiry;
                if ($sampleInquiry) {
                    $sampleInquiry->productionStatus = 'Production Complete';
                    $sampleInquiry->save();
                }

                // Update production
                $production = $rnd->production;
                if ($production) {
                    $production->order_complete_at = now();
                    $production->save();
                }

                // Update inquiry
                $inquiry = $rnd->sampleInquiry;
                if ($inquiry) {
                    $inquiry->productionStatus = 'Production Complete';
                    $inquiry->save();
                }
            } else {
                // Partial completion
                $rnd->productionStatus = 'Production Complete*';
                $rnd->save();

                if ($rnd->production) {
                    $rnd->production->order_complete_at = null; // still ongoing
                    $rnd->production->save();
                }

                if ($rnd->sampleInquiry) {
                    $rnd->sampleInquiry->productionStatus = 'Production Complete*';
                    $rnd->sampleInquiry->save();
                }
            }
        }

        return back()->with('success', 'Shade marked as Production Complete.');
    }


    /**
     * Dispatch selected shades to RnD and update outputs.
     */
    public function dispatchToRnd(Request $request): RedirectResponse
    {
        $request->validate([
            'production_id' => 'required|exists:sample_preparation_production,id',
            'shades' => 'required|array',
        ]);

        $production = SamplePreparationProduction::findOrFail($request->input('production_id'));
        $samplePreparationRnD = $production->samplePreparationRnD;
        $sampleInquiry = $samplePreparationRnD->sampleInquiry;

        $totalProduction = $production->production_output ?? 0;
        $totalDamaged = $production->damaged_output ?? 0;

        $sampleInquiry->productionStatus = 'Dispatched to RnD';
        $sampleInquiry->save();

        $samplePreparationRnD->productionStatus = 'Dispatched to RnD';
        $samplePreparationRnD->save();

        foreach ($request->input('shades') as $shadeId => $shadeData) {
            if (!isset($shadeData['selected'])) {
                continue;
            }

            $shade = ShadeOrder::findOrFail($shadeId);

            $prodOutput = isset($shadeData['production_output']) ? (int)$shadeData['production_output'] : 0;
            $damagedOutput = isset($shadeData['damaged_output']) ? (int)$shadeData['damaged_output'] : 0;
            $dispatchedBy = $shadeData['dispatched_by'] ?? null;

            // Update shade_order
            $shade->production_output = ($shade->production_output ?? 0) + $prodOutput;
            $shade->damaged_output = ($shade->damaged_output ?? 0) + $damagedOutput;
            $shade->dispatched_by = $dispatchedBy;
            $shade->status = 'Dispatched to RnD';
            $shade->dispatched_date = Carbon::now();
            $shade->save();

            // Update totals
            $totalProduction += $prodOutput;
            $totalDamaged += $damagedOutput;
        }

        // Update production table totals
        $production->production_output = $totalProduction;
        $production->damaged_output = $totalDamaged;
        $production->dispatch_to_rnd_at = Carbon::now();
        $production->dispatched_by = $request->shades[array_key_first($request->input('shades'))]['dispatched_by'] ?? $production->dispatched_by;
        $production->save();

        return redirect()->back()->with('success', 'Shades dispatched and outputs updated successfully.');
    }


    /**
     * Update the operator name for a production record.
     */
    public function updateOperator(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'operator_name' => 'required|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($id);
        $production->operator_name = $request->input('operator_name');
        $production->save();

        return redirect()->back()->with('success', 'Operator updated successfully.');
    }


    /**
     * Update the supervisor name for a production record.
     */
    public function updateSupervisor(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'supervisor_name' => 'required|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($id);
        $production->supervisor_name = $request->input('supervisor_name');
        $production->save();

        return redirect()->back()->with('success', 'Supervisor updated successfully.');
    }
}

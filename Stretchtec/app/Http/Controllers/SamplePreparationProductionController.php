<?php

namespace App\Http\Controllers;

use App\Models\SamplePreparationProduction;
use App\Models\ShadeOrder;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SamplePreparationProductionController extends Controller
{
    public function index(Request $request)
    {
        $operators = \App\Models\OperatorsandSupervisors::where('role', 'OPERATOR')->get();
        $supervisors = \App\Models\OperatorsandSupervisors::where('role', 'SUPERVISOR')->get();

        $productionsQuery = SamplePreparationProduction::with([
            'samplePreparationRnD.sampleInquiry',
            'samplePreparationRnD.shadeOrders' // eager load related shade_orders
        ])
            ->orderByRaw('dispatch_to_rnd_at IS NULL DESC') // dispatched rows first
            ->orderBy('production_deadline', 'asc')         // nearest upcoming deadline first
            ->latest();                                     // fallback to newest created

        // Tab 3 Filters
        if ($request->filled('tab') && $request->tab == '3') {
            if ($request->filled('order_no')) {
                $productionsQuery->where('order_no', $request->order_no);
            }

            if ($request->filled('development_plan_date')) {
                $productionsQuery->whereDate('production_deadline', $request->development_plan_date);
            }
        }

        // Apply pagination and keep filters in links
        $productions = $productionsQuery
            ->paginate(10)
            ->appends($request->query());

        // For Order No dropdown
        $orderNosTab3 = SamplePreparationProduction::select('order_no')
            ->distinct()
            ->orderBy('order_no')
            ->pluck('order_no');

        return view('sample-development.pages.sample-preparation-production', compact(
            'productions', 'operators', 'supervisors', 'orderNosTab3'
        ));
    }

    // Update editable fields like operator_name, supervisor_name, production_output, deadline, order_no
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_production,id',
            'operator_name' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($request->id);

        $production->update([
            'operator_name' => $request->operator_name,
            'supervisor_name' => $request->supervisor_name,
            'production_deadline' => $request->production_deadline,
        ]);

        return redirect()->back()->with('success', 'Production record updated successfully.');
    }

    public function markOrderStart(Request $request)
    {
        $request->validate([
            'production_id' => 'required|exists:sample_preparation_production,id',
            'shade_ids' => 'required|array|min:1',
            'shade_ids.*' => 'exists:shade_orders,id',
        ]);

        try {
            $production = SamplePreparationProduction::findOrFail($request->production_id);
            $rnd = $production->samplePreparationRnD;

            if (!$rnd) {
                return back()->with('error', 'No related RnD record found.');
            }

            // Update selected shades to In Production
            ShadeOrder::whereIn('id', $request->shade_ids)->update([
                'status' => 'In Production',
            ]);

            // Set start time if not already set
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


    public function markOrderComplete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_production,id'
        ]);

        try {
            $production = SamplePreparationProduction::findOrFail($request->id);
            $production->order_complete_at = Carbon::now();
            $production->save();

            // Fetch related SamplePreparationRnd record
            $rnd = $production->samplePreparationRnd;

            if ($rnd) {
                // Update productionStatus in sample_preparation_rnd table
                $rnd->productionStatus = 'Production Complete';
                $rnd->save();

                // Fetch related SampleInquiry record
                $inquiry = $rnd->sampleInquiry;

                if ($inquiry) {
                    $inquiry->productionStatus = 'Production Complete';
                    $inquiry->save();
                }
            }

            return redirect()->back()->with('success', 'Order complete date/time marked and production statuses updated.');
        } catch (Exception $e) {
            Log::error('Error in markOrderComplete: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to mark order complete date/time. Please try again.');
        }
    }

    public function dispatchToRnd(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_production,id',
            'dispatched_by' => 'required|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($request->id);
        $production->dispatch_to_rnd_at = Carbon::now();
        $production->dispatched_by = $request->dispatched_by;
        $production->save();

        return redirect()->back()->with('success', 'Dispatched to R&D.');
    }

    public function updateOperator(Request $request, $id)
    {
        $request->validate([
            'operator_name' => 'required|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($id);
        $production->operator_name = $request->operator_name;
        $production->save();

        return redirect()->back()->with('success', 'Operator updated successfully.');
    }

    public function updateSupervisor(Request $request, $id)
    {
        $request->validate([
            'supervisor_name' => 'required|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($id);
        $production->supervisor_name = $request->supervisor_name;
        $production->save();

        return redirect()->back()->with('success', 'Supervisor updated successfully.');
    }

    public function updateOutput(Request $request)
    {
        // Validate input
        $request->validate([
            'id' => 'required|exists:sample_preparation_production,id',
            'production_output' => 'required|numeric|min:0',
        ]);

        // Find the production record
        $prod = SamplePreparationProduction::findOrFail($request->id);

        // Update the production output and lock the field
        $prod->production_output = $request->production_output;
        $prod->is_output_locked = true;
        $prod->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Production output updated and locked.');
    }

    public function updateDamagedOutput(Request $request)
    {
        // Validate input
        $request->validate([
            'id' => 'required|exists:sample_preparation_production,id',
            'damaged_output' => 'required|numeric|min:0',
        ]);

        // Find the production record
        $prod = SamplePreparationProduction::findOrFail($request->id);

        // Update the production output and lock the field
        $prod->damaged_output = $request->damaged_output;
        $prod->is_damagedOutput_locked = true;
        $prod->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Production damaged output updated and locked.');
    }


}

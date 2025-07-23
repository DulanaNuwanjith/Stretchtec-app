<?php

namespace App\Http\Controllers;

use App\Models\SamplePreparationProduction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SamplePreparationProductionController extends Controller
{
    // Show all productions
    public function index()
    {
        $operators = \App\Models\OperatorsandSupervisors::where('role', 'OPERATOR')->get();
        $supervisors = \App\Models\OperatorsandSupervisors::where('role', 'SUPERVISOR')->get();
        $productions = SamplePreparationProduction::latest()->get();
        return view('sample-development.pages.sample-preparation-production', compact('productions', 'operators', 'supervisors'));
    }

    // Update editable fields like operator_name, supervisor_name, production_output, note, deadline, order_no
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sample_preparation_production,id',
            'operator_name' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'production_output' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'order_no' => 'nullable|string|max:255',
        ]);

        $production = SamplePreparationProduction::findOrFail($request->id);

        $production->update([
            'operator_name' => $request->operator_name,
            'supervisor_name' => $request->supervisor_name,
            'production_output' => $request->production_output,
            'note' => $request->note,
            'production_deadline' => $request->production_deadline,
            'order_no' => $request->order_no,
        ]);

        return back()->with('success', 'Production record updated successfully.');
    }

    // Mark order start date/time
    public function markOrderStart(Request $request)
    {
        $request->validate(['id' => 'required|exists:sample_preparation_production,id']);

        $production = SamplePreparationProduction::findOrFail($request->id);
        $production->order_start_at = Carbon::now();
        $production->save();

        return back()->with('success', 'Order start date/time marked.');
    }

    // Mark order complete date/time
    public function markOrderComplete(Request $request)
    {
        $request->validate(['id' => 'required|exists:sample_preparation_production,id']);

        $production = SamplePreparationProduction::findOrFail($request->id);
        $production->order_complete_at = Carbon::now();
        $production->save();

        return back()->with('success', 'Order complete date/time marked.');
    }

    // Mark dispatch to R&D date/time
    public function dispatchToRnd(Request $request)
    {
        $request->validate(['id' => 'required|exists:sample_preparation_production,id']);

        $production = SamplePreparationProduction::findOrFail($request->id);
        $production->dispatch_to_rnd_at = Carbon::now();
        $production->save();

        return back()->with('success', 'Dispatched to R&D.');
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
}

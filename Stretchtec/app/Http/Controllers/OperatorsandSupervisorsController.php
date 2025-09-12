<?php

namespace App\Http\Controllers;

use App\Models\OperatorsandSupervisors;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Factory;
use Illuminate\View\View;

class OperatorsandSupervisorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|RedirectResponse
    {
        try {
            // Order by 'empID' ascending before pagination
            $operatorsAndSupervisors = OperatorsandSupervisors::orderBy('empID', 'asc')->paginate(10);

            // Return Blade view with data
            return view('user-management.pages.addResponsiblePerson', compact('operatorsAndSupervisors'));

        } catch (Exception $e) {
            Log::error('Failed to fetch Operators and Supervisors: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ?RedirectResponse
    {
        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'empID' => 'required|unique:operatorsand_supervisors,empID',
                'name' => 'required|string|max:255',
                'phoneNo' => ['required', 'regex:/^[0-9]{10}$/'],
                'address' => 'nullable|string|max:255',
                'role' => 'required|in:OPERATOR,SUPERVISOR',
            ], [
                'phoneNo.regex' => 'The phone number must be exactly 10 digits.',
            ]);

            // Only fill fields that are necessary
            OperatorsandSupervisors::create([
                'empID' => $validatedData['empID'],
                'name' => $validatedData['name'],
                'phoneNo' => $validatedData['phoneNo'],
                'address' => $validatedData['address'] ?? null,
                'role' => $validatedData['role'],
            ]);

            // Redirect back with the success message
            return redirect()->back()->with('success', 'Operator or Supervisor created successfully.');

        } catch (Exception $e) {
            // Log unexpected errors
            Log::error('Failed to create Operator or Supervisor: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(OperatorsandSupervisors $operatorsandSupervisors): void
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperatorsandSupervisors $operatorsandSupervisors): void
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OperatorsandSupervisors $operatorsandSupervisors): JsonResponse
    {
        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'empID' => 'required|unique:operatorsand_supervisors,empID,' . $operatorsandSupervisors->id,
                'name' => 'required|string|max:255',
                'phoneNo' => 'required|string|max:15',
                'address' => 'nullable|string|max:255',
                'role' => 'required|in:operator,supervisor',
            ]);

            // Update the operator or supervisor
            $operatorsandSupervisors->update($validatedData);

            return response()->json([
                'message' => 'Operator or Supervisor updated successfully'
            ]);

        } catch (Exception $e) {
            // Log unexpected errors
            Log::error('Failed to update Operator or Supervisor: ' . $e->getMessage());

            return response()->json([
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            // Manually find by ID to ensure deletion works even if route binding breaks
            $record = OperatorsandSupervisors::findOrFail($id);

            $record->delete();

            return redirect()->back()->with('success', 'Operator or Supervisor deleted successfully.');

        } catch (Exception $e) {
            Log::error('Failed to delete Operator or Supervisor: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred while deleting the Operator or Supervisor.');
        }
    }
}

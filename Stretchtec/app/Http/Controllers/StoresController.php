<?php

namespace App\Http\Controllers;

use App\Models\SampleStock;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get search term if any
        $search = $request->input('search');

        // Query with optional search filter
        $query = SampleStock::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhere('shade', 'like', "%{$search}%")
                    ->orWhere('special_note', 'like', "%{$search}%");
            });
        }

        // Paginate results, e.g. 10 per page
        $sampleStocks = $query->orderBy('reference_no')->paginate(10);

        $sampleStocks->appends(['search' => $search]);

        return view('store-management.storeManagement', compact('sampleStocks', 'search'));

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
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Stores $stores)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stores $stores)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stores $stores)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stores $stores)
    {
        //
    }
}

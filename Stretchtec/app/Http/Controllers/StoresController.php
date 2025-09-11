<?php

namespace App\Http\Controllers;

use App\Models\SampleStock;
use App\Models\Stores;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory
    {
        // Get search term if any
        $search = $request->input('search');

        // Query with optional search filter
        $query = SampleStock::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%$search%")
                    ->orWhere('shade', 'like', "%$search%")
                    ->orWhere('special_note', 'like', "%$search%");
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
    public function create(): void
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Stores $stores): void
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stores $stores): void
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stores $stores): void
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stores $stores): void
    {
        //
    }
}

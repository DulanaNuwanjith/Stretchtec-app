<?php

namespace App\Http\Controllers;

use App\Models\LeftoverYarn;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class LeftoverYarnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory
    {
        $search = $request->input('search');

        $leftoverYarns = LeftoverYarn::query()
            ->when($search, function ($query, $search) {
                $query->where('shade', 'like', "%$search%")
                    ->orWhere('po_number', 'like', "%$search%")
                    ->orWhere('yarn_supplier', 'like', "%$search%");
                // Add other searchable columns here if needed
            })
            ->paginate(10) // Adjust pagination size as needed
            ->withQueryString(); // Keeps search query param on pagination links

        return view('sample-development.leftover-yarn-details', compact('leftoverYarns', 'search'));
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
    public function show(LeftoverYarn $leftoverYarn): void
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeftoverYarn $leftoverYarn): void
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeftoverYarn $leftoverYarn): void
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeftoverYarn $leftoverYarn): void
    {
        //
    }
}

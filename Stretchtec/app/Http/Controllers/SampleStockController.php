<?php

namespace App\Http\Controllers;

use App\Models\SampleStock;
use Illuminate\Http\Request;

class SampleStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sampleStocks = SampleStock::all();
        return view('sample-development.sample-stock-management', compact('sampleStocks'));
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
    public function show(SampleStock $sampleStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SampleStock $sampleStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SampleStock $sampleStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SampleStock $sampleStock)
    {
        //
    }
}

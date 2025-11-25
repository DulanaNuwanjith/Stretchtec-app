<?php

namespace App\Http\Controllers;

use App\Models\LocalProcurement;
use Illuminate\Http\Request;

class LocalProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $localProcurements = LocalProcurement::orderBy('id', 'desc')->paginate(10);
        return view('purchasingDepartment.localinvoiceManage', compact('localProcurements'));
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
    public function show(LocalProcurement $localProcurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LocalProcurement $localProcurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LocalProcurement $localProcurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocalProcurement $localProcurement)
    {
        //
    }
}

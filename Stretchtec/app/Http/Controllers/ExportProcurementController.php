<?php

namespace App\Http\Controllers;

use App\Models\ExportProcurement;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ExportProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $exportProcurements = ExportProcurement::latest()->paginate(10);
        return view('purchasingDepartment.exportinvoiceManage', compact('exportProcurements'));
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
    public function show(ExportProcurement $exportProcurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExportProcurement $exportProcurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExportProcurement $exportProcurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExportProcurement $exportProcurement)
    {
        //
    }
}

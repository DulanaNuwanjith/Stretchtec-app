<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDepartment;
use Illuminate\Http\Request;

class PurchaseDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase_department = PurchaseDepartment::all();
        return view('purchasingDepartment.purchasing', compact('purchase_department'));
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
    public function show(PurchaseDepartment $purchaseDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseDepartment $purchaseDepartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseDepartment $purchaseDepartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseDepartment $purchaseDepartment)
    {
        //
    }
}

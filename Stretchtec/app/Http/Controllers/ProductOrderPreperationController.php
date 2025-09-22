<?php

namespace App\Http\Controllers;

use App\Models\ProductOrderPreperation;
use Illuminate\Http\Request;

class ProductOrderPreperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('production.pages.production-order-preparation');
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
    public function show(ProductOrderPreperation $productOrderPreperation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductOrderPreperation $productOrderPreperation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductOrderPreperation $productOrderPreperation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductOrderPreperation $productOrderPreperation)
    {
        //
    }
}

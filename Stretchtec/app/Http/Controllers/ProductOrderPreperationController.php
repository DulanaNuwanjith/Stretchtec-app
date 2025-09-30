<?php

namespace App\Http\Controllers;

use App\Models\ProductOrderPreperation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductOrderPreperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        // Fetch all records with pagination (adjust number per page as needed)
        $orderPreparations = ProductOrderPreperation::latest()->paginate(10);

        // Pass data to the blade
        return view('production.pages.production-order-preparation', compact('orderPreparations'));
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

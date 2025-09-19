<?php

namespace App\Http\Controllers;

use App\Models\TechnicalCard;
use Illuminate\Http\Request;

class TechnicalCardController extends Controller
{
    public function elasticIndex()
    {
        return view('technical-details.pages.elasticTD');
    }

    public function tapeIndex()
    {
        return view('technical-details.pages.tapeTD');
    }

    public function cordIndex()
    {
        return view('technical-details.pages.cordTD');
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
    public function show(TechnicalCard $technicalCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechnicalCard $technicalCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechnicalCard $technicalCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnicalCard $technicalCard)
    {
        //
    }
}

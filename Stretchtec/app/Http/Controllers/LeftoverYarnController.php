<?php

namespace App\Http\Controllers;

use App\Models\LeftoverYarn;
use Illuminate\Http\Request;

class LeftoverYarnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leftoverYarns = LeftoverYarn::all();
        return view('sample-development.leftover-yarn-details', compact('leftoverYarns'));
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
    public function show(LeftoverYarn $leftoverYarn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeftoverYarn $leftoverYarn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeftoverYarn $leftoverYarn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeftoverYarn $leftoverYarn)
    {
        //
    }
}

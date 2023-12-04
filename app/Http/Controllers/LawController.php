<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLawsRequest;
use App\Http\Requests\UpdateLawsRequest;
use App\Models\Law;

class LawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreLawsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Law $laws)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Law $laws)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLawsRequest $request, Law $laws)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Law $laws)
    {
        //
    }
}

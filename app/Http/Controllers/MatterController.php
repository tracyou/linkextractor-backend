<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMatterRequest;
use App\Http\Requests\UpdateMatterRequest;
use App\Models\Matter;

class MatterController extends Controller
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
    public function store(StoreMatterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Matter $matter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matter $matter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatterRequest $request, Matter $matter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matter $matter)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tank;
use Illuminate\Http\Request;

class TankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tank::all();
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
    public function show(Tank $tank)
    {
        return $tank;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tank $tank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tank $tank)
    {
        //
    }
}

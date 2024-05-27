<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TankController extends CouchbaseController
{
    public function getCollectionName()
    {
        return 'tanks';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->getAllDocuments($this->getCollectionName());
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
    public function show($id)
    {
        return $this->getDocumentById($this->getCollectionName(), $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}

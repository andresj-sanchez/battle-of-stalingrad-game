<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScoreController extends CouchbaseController
{
    public function getCollectionName()
    {
        return 'scores';
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
        $request->validate([
            'player_id' => 'required|uuid',
            'score' => 'required|integer|min:0',
        ]);

        // Generate timestamps
        $created_at = now()->toISOString();
        $updated_at = $created_at;

        // Create the score document
        $score = [
            'player_id' => $request->input('player_id'),
            'score' => $request->input('score'),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];

        // Insert the document into Couchbase
        $result = $this->insertDocument($this->getCollectionName(), $score);

        // Check the result of the insert operation
        if ($result->status() !== 200) {
            return response()->json(['error' => 'Failed to save score'], 500);
        }

        $responseData = json_decode($result->getContent(), true);

        // Add the document ID to the score
        $score['id'] = $responseData['documentId'];

        return response()->json($score, 201);
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

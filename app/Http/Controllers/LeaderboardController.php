<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends CouchbaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = sprintf(
            'SELECT player_id, MAX(score) AS top_score FROM `%s`.`%s`.`scores` GROUP BY player_id ORDER BY top_score DESC',
            $this->bucketName,
            $this->scopeName
        );

        $results = $this->queryDocuments($query);

        // Check if results were fetched successfully
        if ($results->status() !== 200) {
            return $results; // Return the error response
        }

        $leaderboards = ['global_leaderboards' => $results->getData()];

        return response()->json($leaderboards);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

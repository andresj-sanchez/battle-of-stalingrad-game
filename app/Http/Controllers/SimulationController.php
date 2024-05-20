<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tank;
use App\Models\Map;
use App\Models\Score;
use Illuminate\Support\Str;

class SimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    /**
     * Simulates a battle between two tanks on a given map and returns the winner and score.
     */
    public function simulate(Request $request)
    {
        $request->validate([
            'tanks' => 'required|array|size:2',
            'tanks.*' => 'uuid|exists:tanks,id',
            'mapid' => 'required|uuid|exists:maps,id',
        ]);

        $tank1 = Tank::findOrFail($request->tanks[0]);
        $tank2 = Tank::findOrFail($request->tanks[1]);
        // $map = Map::findOrFail($request->mapid);

        // Simple simulation logic (replace with your own logic)
        $winner = rand(0, 1) ? $tank1 : $tank2;

        // Save score
        $score = Score::create([
            'id' => (string) Str::uuid(),
            'player_id' => $winner->id, // Assuming Tank has a relation to Player
            'score' => rand(100, 1000),
        ]);

        return response()->json(['winner' => $winner, 'score' => $score]);
    }
}

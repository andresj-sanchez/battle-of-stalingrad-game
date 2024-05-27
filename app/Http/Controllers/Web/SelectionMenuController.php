<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\CouchbaseController;
use Illuminate\Http\Request;

class SelectionMenuController extends CouchbaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tanksResponse = $this->getAllDocuments('tanks');
        if ($tanksResponse->getStatusCode() !== 200) {
            return response()->json(['error' => 'No tanks available'], 400);
        }
        $tanks = json_decode($tanksResponse->getContent(), true);

        $mapsResponse = $this->getAllDocuments('maps');
        if ($mapsResponse->getStatusCode() !== 200) {
            return response()->json(['error' => 'No maps available'], 400);
        }
        $maps = json_decode($mapsResponse->getContent(), true);

        // return response()->json($leaderboards);
        return view('selectMenu', compact('tanks', 'maps'));
    }
}

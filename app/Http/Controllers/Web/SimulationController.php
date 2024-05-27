<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Game\Services\GameService;
use App\Http\Controllers\CouchbaseController;
use Illuminate\Support\Facades\Validator;

class SimulationController extends CouchbaseController
{
    /**
     * Simulates a battle between two tanks on a given map and returns the winner and score.
     */
    public function simulate(Request $request)
    {
        
        $request->validate([
            'tanks' => 'required|array|size:2',
            'tanks.*' => 'uuid|distinct',
            'map_id' => 'required|uuid',
        ]);

        // // Define validation rules
        // $rules = [
        //     'tanks' => 'required|array|size:2',
        //     'tanks.*' => 'uuid',
        //     'map_id' => 'required|uuid',
        // ];

        // // Create a validator instance and validate the request
        // $validator = Validator::make($request->all(), $rules);

        // // Check if the validation fails
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 400);
        // }

        $tank1Response = $this->getDocumentById($this->getTankCollectionName(), $request->tanks[0]);
        $tank2Response = $this->getDocumentById($this->getTankCollectionName(), $request->tanks[1]);
        $mapResponse = $this->getDocumentById($this->getMapCollectionName(), $request->map_id);
        $playersResponse = $this->getAllDocuments($this->getPlayerCollectionName());

        if ($tank1Response->getStatusCode() !== 200 || $tank2Response->getStatusCode() !== 200 || $mapResponse->getStatusCode() !== 200) {
            return response()->json(['error' => 'Invalid tanks or map ID'], 400);
        } elseif ($playersResponse->getStatusCode() !== 200) {
            return response()->json(['error' => 'No players available'], 400);
        }

        $tank1Data = json_decode($tank1Response->getContent(), true);
        $tank2Data = json_decode($tank2Response->getContent(), true);
        $mapData = json_decode($mapResponse->getContent(), true);
        $playersData = json_decode($playersResponse->getContent(), true);

        // Select 2 unique random players
        $playerCount = count($playersData);
        if ($playerCount < 2) {
            return response()->json(['error' => 'Not enough players available'], 400);
        }

        $randomKeys = array_rand($playersData, 2);
        $player1 = $playersData[$randomKeys[0]];
        $player2 = $playersData[$randomKeys[1]];

        // Now assign the tanks to the selected players
        $player1["tank"] = $tank1Data;
        $player2["tank"] = $tank2Data;
        // $tank1Data['player_id'] = $player1['id'];
        // $tank2Data['player_id'] = $player2['id'];

        $gameService = new GameService();
        $gameResult = $gameService->simulateGame([$player1, $player2], $mapData);

        // Check if the game session ended due to an inaccessible path
        if (isset($gameResult['message']) && is_null($gameResult['winner'])) {
            return response()->json($gameResult, 400);
        }

        $gameSession = $gameResult['gameSession'];
        $scoreData = $gameResult['scoreData'];

        // Set the map ID on the game session
        $gameSession->setMapId($request->map_id);
        // $scoreData = [
        //     'player_id' => $result['winner']->id,
        //     'score' => $result['score'],
        // ];

        // $scoreRequest = new Request($scoreData);

        // // Instantiate the ScoreController and call the store method
        // $scoreController = new ScoreController();
        // $scoreResult = $scoreController->store($scoreRequest);

        $scoreResult = $this->insertDocument($this->getScoreCollectionName(), $scoreData);
        
        if ($scoreResult->getStatusCode() !== 200) {
            return $scoreResult;
        }

        $responseData = json_decode($scoreResult->getContent(), true);

        // Add the document ID to the score
        $scoreData['id'] = $responseData['documentId'];

        $gameSession->setScore($scoreData);

        $gameSessionArray = $gameSession->toArray();

        $gameResult = $this->insertDocument($this->getGameSessionCollectionName(), $gameSessionArray);

        if ($gameResult->getStatusCode() !== 200) {
            return $gameResult;
        }

        $responseData = json_decode($gameResult->getContent(), true);

        $gameSessionArray['id'] = $responseData['documentId'];

        // return response()->json($gameSessionArray);
        return view('simulation', compact('gameSessionArray', 'mapData'));
    }

    public function getTankCollectionName()
    {
        return 'tanks';
    }

    public function getMapCollectionName()
    {
        return 'maps';
    }

    public function getScoreCollectionName()
    {
        return 'scores';
    }

    public function getPlayerCollectionName()
    {
        return 'players';
    }

    public function getGameSessionCollectionName()
    {
        return 'gameSessions';
    }
}

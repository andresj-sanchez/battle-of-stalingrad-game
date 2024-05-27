<?php

namespace App\Game\Services;

use App\Game\Models\Tank;
use App\Game\Models\Map;
use App\Game\Models\GameSession;
use App\Game\Controllers\GameSessionController;
use Illuminate\Support\Str;

class GameService
{
    public function simulateGame(array $playerData, array $mapData)
    {
        $map = new Map($mapData['grid']);

        // Spawn tanks on the map
        $this->spawnTanks($map, $playerData[0]['tank'], $playerData[1]['tank']);

        $tanks = [
            new Tank(
                $playerData[0]['tank']['id'],
                $playerData[0]['id'],
                $playerData[0]['tank']['type'],
                $playerData[0]['tank']['speed'],
                $playerData[0]['tank']['turret_range'],
                $playerData[0]['tank']['health_points'],
                $playerData[0]['tank']['x'],
                $playerData[0]['tank']['y']
            ),
            new Tank(
                $playerData[1]['tank']['id'],
                $playerData[0]['id'],
                $playerData[1]['tank']['type'],
                $playerData[1]['tank']['speed'],
                $playerData[1]['tank']['turret_range'],
                $playerData[1]['tank']['health_points'],
                $playerData[1]['tank']['x'],
                $playerData[1]['tank']['y']
            )
        ];

        // Create a new GameSession
        $gameSession = new GameSession($playerData);

        $gameSessionController = new GameSessionController($tanks, $map);
        $result = $gameSessionController->start();

        // Check if the game session ended due to an inaccessible path
        if (isset($result['message']) && is_null($result['winner'])) {
            return $result;
        }

        // Update the GameSession with results
        $gameSession->setWinner($result['winner']);
        foreach ($result['turnLogs'] as $log) {
            $gameSession->addTurnLog($log);
        }

        // Handle score data
        $scoreData = [
            'player_id' => $result['winner'],
            'score' => $result['score'],
        ];

        return [
            'gameSession' => $gameSession, 
            'scoreData' => $scoreData
        ];
    }

    private function isObstacle($y, $x, $map)
    {
        return $map->isObstacle($y, $x);
    }

    private function generateRandomPosition($map)
    {
        $width = count($map->getGrid());
        $height = count($map->getGrid()[0]);

        do {
            $y = rand(0, $width - 1);
            $x = rand(0, $height - 1);
        } while ($this->isObstacle($y, $x, $map));

        return ['x' => $x, 'y' => $y];
    }

    private function spawnTanks($map, &$tank1, &$tank2)
    {
        $tank1Pos = $this->generateRandomPosition($map);
        $tank1['x'] = $tank1Pos['x'];
        $tank1['y'] = $tank1Pos['y'];

        do {
            $tank2Pos = $this->generateRandomPosition($map);
        } while ($tank2Pos['x'] == $tank1Pos['x'] && $tank2Pos['y'] == $tank1Pos['y']);

        $tank2['x'] = $tank2Pos['x'];
        $tank2['y'] = $tank2Pos['y'];
    }
}

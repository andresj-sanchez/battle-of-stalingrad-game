<?php

namespace App\Game\Controllers;

ini_set('max_execution_time', 60); //1 min

use App\Game\Models\Tank;
use App\Game\Models\Map;
use App\Game\Models\TurnLog;
use App\Game\Services\Pathfinding\AStarPathfinder;

class GameSessionController
{
    private $tanks;
    private $map;
    // private $pathfinder;
    private $turnLogs;
    private $turnNumber;

    public function __construct(array $tanks, Map $map)
    {
        $this->tanks = $tanks;
        $this->map = $map;
        // $this->pathfinder = new AStarPathfinder($map);
        $this->turnLogs = [];
        $this->turnNumber = 0;
    }

    public function start()
    {
        while (!$this->isGameOver()) {
            $this->turnNumber++;
            $actions = [];

            foreach ($this->tanks as $tank) {
                if ($tank->isDestroyed()) continue;

                // Example simple AI: move towards the opponent
                $targetTank = $this->findOpponent($tank);
                $pathfinder = new AStarPathfinder($this->map);
                $path = $pathfinder->findPath($tank->getY(), $tank->getX(), $targetTank->getY(), $targetTank->getX());
                // $path = $this->pathfinder->findPath($tank->x, $tank->y, $targetTank->x, $targetTank->y);

                // Handle the case when the path is empty
                if (empty($path)) {
                    // You can end the game session here
                    return $this->handleEmptyPath();
                }
                
                if (!$this->isInRange($tank, $targetTank)) {
                    // $nextStep = array_shift($path);
                    // if (empty($path)) {
                    //     dd([
                    //         'message' => 'Current tank position, target position, and path',
                    //         'tank' => [
                    //             'x' => $tank->getX(),
                    //             'y' => $tank->getY(),
                    //         ],
                    //         'targetTank' => [
                    //             'x' => $targetTank->getX(),
                    //             'y' => $targetTank->getY(),
                    //         ],
                    //         'path' => $path
                    //     ]);
                    // }
                    $actions[] = $tank->move($path, $targetTank);
                    // $actions[] = ['tank' => $tank->id, 'action' => 'move', 'x' => $nextStep->getX(), 'y' => $nextStep->getY()];
                }else{
                    $tank->attack($targetTank);
                    $actions[] = ['tank' => $tank->getId(), 'action' => 'attack', 'target' => $targetTank->getId()];
                }

            }

            $tankStates = array_map(fn($tank) => [
                'id' => $tank->getId(),
                'type' => $tank->getType(),
                'x' => $tank->getX(),
                'y' => $tank->getY(),
                'healthPoints' => $tank->getHealthPoints()
            ], $this->tanks);

            $this->turnLogs[] = new TurnLog($this->turnNumber, $tankStates, $actions);
        }

        // dd([
        //     'message' => 'Current tank position, target position, and path',
        //     'tank_1' => [
        //         'x' => $this->tanks[0]->x,
        //         'y' => $this->tanks[0]->y,
        //     ],
        //     'tank_2' => [
        //         'x' => $this->tanks[1]->x,
        //         'y' => $this->tanks[1]->y,
        //     ],
        //     'tanks' => $this->tanks,
        //     'path' => $path,
        //     'turnLogs' => $this->turnLogs
        // ]);

        return $this->getResults();
    }

    private function isGameOver()
    {
        $aliveTanks = array_filter($this->tanks, fn($tank) => !$tank->isDestroyed());
        return count($aliveTanks) <= 1;
    }

    private function findOpponent(Tank $tank)
    {
        foreach ($this->tanks as $opponent) {
            if ($opponent->getId() !== $tank->getId()) {
                return $opponent;
            }
        }
        return null;
    }

    private function isInRange(Tank $tank, Tank $targetTank)
    {
        $distance = sqrt(pow($tank->getX() - $targetTank->getX(), 2) + pow($tank->getY() - $targetTank->getY(), 2));
        return $distance <= $tank->getTurretRange();
    }

    private function getResults()
    {
        try {
            $winnerTank = array_values(array_filter($this->tanks, fn($tank) => !$tank->isDestroyed()))[0];
        } catch (\Exception $e) {
            $winnerTank = array_values(array_filter($this->tanks, fn($tank) => !$tank->isDestroyed()));
            dd([
                'exception' => $e,
                'message' => 'Current path',
                'tanks' => $this->tanks,
                'winner' => $winnerTank
            ]);
        }
        return [
            'winner' => $winnerTank->getPlayerId(),
            'score' => 100, // Example score
            'turnLogs' => $this->turnLogs
        ];
    }


    private function handleEmptyPath()
    {
        // Perform actions to handle the case when the path is empty
        // For example, end the game session
        // You can return any specific result or perform any necessary cleanup
        // For now, let's return a response indicating the game session has ended
        return [
            'winner' => null,
            'score' => 0,
            'turnLogs' => [],
            'message' => 'Game session ended due to inaccessible path'
        ];
    }
}

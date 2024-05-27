<?php

namespace App\Game\Services\Pathfinding;

use BlackScorp\Astar\Grid;
use BlackScorp\Astar\Astar;
use BlackScorp\Astar\Heuristic\Euclidean;
use App\Game\Models\Map;

class AStarPathfinder
{
    private $astar;
    private $grid;

    public function __construct(Map $map)
    {
        // $gridData = $this->mapToGrid($map);
        $this->grid = new Grid($map->getGrid());
        $this->astar = new Astar($this->grid);
        $this->astar->setHeuristic(new Euclidean());
        $this->astar->blocked($map->getBlockedCells());
    }

    // private function mapToGrid(Map $map)
    // {
    //     $gridData = [];
    //     $mapGrid = $map->getGrid();
    //     for ($y = 0; $y < count($mapGrid); $y++) {
    //         for ($x = 0; $x < count($mapGrid[$y]); $x++) {
    //             $gridData[$y][$x] = $map->isObstacle($x, $y) ? 1 : 0;
    //         }
    //     }
    //     return $gridData;
    // }

    // private function getBlockedCells(Map $map)
    // {
    //     $blockedCells = [];
    //     $mapGrid = $map->getGrid();
    //     for ($y = 0; $y < count($mapGrid); $x++) {
    //         for ($x = 0; $x < count($mapGrid[$x]); $y++) {
    //             if ($map->isObstacle($x, $y)) {
    //                 $blockedCells[] = [$x, $y];
    //             }
    //         }
    //     }

    //     // foreach ($map->getGrid() as $x => $row) {
    //     //     foreach ($row as $y => $cell) {
    //     //         if ($map->isObstacle($x, $y)) {
    //     //             $blockedCells[] = [$x, $y];
    //     //         }
    //     //     }
    //     // }
        
    //     return $blockedCells;
    // }

    public function findPath($startY, $startX, $endY, $endX)
    {
        $startPosition = $this->grid->getPoint($startY, $startX);
        $endPosition = $this->grid->getPoint($endY, $endX);
        return $this->astar->search($startPosition, $endPosition);
    }
}

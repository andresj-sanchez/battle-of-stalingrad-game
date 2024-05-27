<?php

namespace App\Game\Models;

use Illuminate\Support\Facades\DB;
use App\Enums\GridState;

class Map
{
    private $grid;

    public function __construct(array $grid)
    {
        $this->grid = $grid;
    }

    public function getCellState($y, $x)
    {
        // dd($this->grid);
        return $this->grid[$y][$x];
    }

    public function isObstacle($y, $x)
    {
        return $this->getCellState($y, $x) === GridState::Obstacle;
    }

    public function getGrid()
    {
        return $this->grid;
    }

    public function getBlockedCells()
    {
        return array(GridState::Obstacle);
    }
}

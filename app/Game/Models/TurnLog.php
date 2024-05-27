<?php

namespace App\Game\Models;

class TurnLog
{
    public $turnNumber;
    public $tankStates;
    public $actions;

    public function __construct($turnNumber, $tankStates, $actions)
    {
        $this->turnNumber = $turnNumber;
        $this->tankStates = $tankStates;
        $this->actions = $actions;
    }
}

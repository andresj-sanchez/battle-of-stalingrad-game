<?php

namespace App\Game\Models;

class GameSession
{
    private $mapId;
    private $winner;
    private $score;
    private $players;
    private $turnLogs;

    public function __construct($players)
    {
        $this->mapId = null;
        $this->players = $players;
        $this->turnLogs = [];
        $this->winner = null;
        $this->score = null;
    }

    public function getMapId()
    {
        return $this->mapId;
    }

    public function setMapId($mapId)
    {
        $this->mapId = $mapId;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function setPlayers($players)
    {
        $this->players = $players;
    }

    public function getTurnLogs()
    {
        return $this->turnLogs;
    }

    public function addTurnLog($log)
    {
        $this->turnLogs[] = $log;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    public function toArray()
    {
        return [
            'map_id' => $this->mapId,
            'winner' => $this->winner,
            'score' => $this->score,
            'players' => $this->players,
            'turn_logs' => $this->turnLogs,
        ];
    }
}

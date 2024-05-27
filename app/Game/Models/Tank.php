<?php

namespace App\Game\Models;

use App\Wrappers\NodeWrapper;

class Tank
{
    private $id;
    private $type;
    private $speed;
    private $turretRange;
    private $healthPoints;
    private $x;
    private $y;
    private $player_id;

    public function __construct($id, $player_id, $type, $speed, $turretRange, $healthPoints, $x, $y)
    {
        $this->id = $id;
        $this->player_id = $player_id ?? null;
        $this->type = $type;
        $this->speed = $speed;
        $this->turretRange = $turretRange;
        $this->healthPoints = $healthPoints;
        $this->x = $x;
        $this->y = $y;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPlayerId()
    {
        return $this->player_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function getTurretRange()
    {
        return $this->turretRange;
    }

    public function getHealthPoints()
    {
        return $this->healthPoints;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPlayerId($player_id)
    {
        $this->player_id = $player_id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    public function setTurretRange($turretRange)
    {
        $this->turretRange = $turretRange;
    }

    public function setHealthPoints($healthPoints)
    {
        $this->healthPoints = $healthPoints;
    }

    public function setX($x)
    {
        $this->x = $x;
    }

    public function setY($y)
    {
        $this->y = $y;
    }

    public function move($path, $targetTank)
    {
        $startingPosition = [
            'x' => $this->getX(),
            'y' => $this->getY()
        ];

        // Convert each Node object in the path array to a serialized representation
        $pathSerialized = array_map(function ($node) {
            return new NodeWrapper($node);
        }, $path);

        // Remove the first and last elements from the path array - tank and target tank positions
        $pathToMove = array_slice($path, 1, -1);

        // Tank's speed determines how many steps it can move per turn
        $speed = $this->speed;

        // Initialize steps array
        $steps = [];

        // Determine the maximum number of steps the tank can move
        $maxSteps = min($speed, count($pathToMove));

        // Move the tank along the path, we start from 1 to avoid first position (current position)
        for ($i = 0; $i < $maxSteps; $i++) {
            $node = $pathToMove[$i];
            $this->setX($node->getX());
            $this->setY($node->getY());
            $steps[] = [
                'x' => $this->getX(),
                'y' => $this->getY(),
            ];
        }

        // dd($path, $pathSerialized);

        // if (empty($steps)) {
        //     dd([
        //         'message' => 'Current path',
        //         'path' => $path
        //     ]);
        // }

        // Return the updated tank position and actions
        return [
            'tank' => $this->getId(),
            'action' => 'move',
            'target' => $targetTank->getId(),
            'steps' => $steps,
            'path' => $pathSerialized
        ];
    }

    public function attack(Tank $target)
    {
        $target->setHealthPoints($target->getHealthPoints() - 10); // Example damage value
    }

    public function isDestroyed()
    {
        return $this->healthPoints <= 0;
    }
}

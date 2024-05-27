<?php

namespace App\Wrappers;

use JsonSerializable;
use BlackScorp\Astar\Node as AstarNode;

class NodeWrapper implements JsonSerializable
{
    private $node;

    public function __construct(AstarNode $node)
    {
        $this->node = $node;
    }

    public function jsonSerialize()
    {
        return [
            'x' => $this->node->getX(),
            'y' => $this->node->getY(),
            'costs' => $this->node->getCosts(),
            'visited' => $this->node->isVisited(),
            'closed' => $this->node->isClosed(),
            'parent' => $this->node->getParent(),
            'totalScore' => $this->node->getTotalScore(),
            'guessedScore' => $this->node->getGuessedScore(),
            'score' => $this->node->getScore(),
        ];
    }
}

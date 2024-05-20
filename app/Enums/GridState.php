<?php

namespace App\Enums;

enum GridState: int
{
    case Empty = 0;
    case Obstacle = 10;
    case Tank = 20;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['type', 'speed', 'turret_range', 'health_points'];
}

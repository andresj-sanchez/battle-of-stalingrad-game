<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory, HasUuids;

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

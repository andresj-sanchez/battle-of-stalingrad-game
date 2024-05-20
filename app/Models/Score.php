<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['score'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

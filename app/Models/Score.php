<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use FriendsOfCat\Couchbase\Eloquent\Model as CouchbaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends CouchbaseModel
{
    use HasFactory, HasUuids;

    protected $fillable = ['score'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

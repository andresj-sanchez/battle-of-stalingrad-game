<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use FriendsOfCat\Couchbase\Eloquent\Model as CouchbaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends CouchbaseModel
{
    use HasFactory, HasUuids;

    protected $fillable = ['name'];

    public function score(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}

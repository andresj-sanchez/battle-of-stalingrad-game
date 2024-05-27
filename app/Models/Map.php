<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use FriendsOfCat\Couchbase\Eloquent\Model as CouchbaseModel;

class Map extends CouchbaseModel
{
    use HasFactory, HasUuids;

    protected $fillable = ['grid'];

    protected $casts = [
        'grid' => 'array',
    ];
}

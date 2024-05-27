<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use FriendsOfCat\Couchbase\Eloquent\Model as CouchbaseModel;

class Tank extends CouchbaseModel
{
    use HasFactory, HasUuids;

    protected $fillable = ['type', 'speed', 'turret_range', 'health_points'];
}

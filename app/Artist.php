<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = [
        'artist_id',
        'name',
        'popularity',
        'played_at',
        'tracked_by',
        'album_id',
        'track_id'
    ];
}

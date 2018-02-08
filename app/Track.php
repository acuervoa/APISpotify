<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable=[
        'played_at',
        'track_id',
        'name',
        'popularity',
    ];
}

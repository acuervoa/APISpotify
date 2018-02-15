<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name',
        'played_at',
        'tracked_by',
        'album_id'
    ];
}

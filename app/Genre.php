<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name',
    ];

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_genres', 'genre_id');
    }
}

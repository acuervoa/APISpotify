<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'genre_id',
        'name',
    ];

    protected $primaryKey = 'genre_id';

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_genres', 'genre_id', 'artist_id');
    }
}

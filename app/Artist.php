<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Illuminate\Database\Eloquent\Model;
use SpotifyWebAPI\SpotifyWebAPI;

class Artist extends Model
{
    protected $fillable = [
        'artist_id',
        'name',
        'image_url',
        'link_to'
    ];

    public function albums() {
        return $this->belongsToMany(Album::class, 'album_artists', 'artist_id');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'artist_genres', 'artist_id');
    }

}

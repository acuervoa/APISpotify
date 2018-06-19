<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{

    protected $fillable = [
        'album_id',
        'name',
        'image_url_640x640',
        'image_url_300x300',
        'image_url_64x64',
        'link_to'
    ];

    protected $primaryKey = 'album_id';

    public $incrementing=false;


    public function tracks(){
        return $this->hasMany(Track::class, 'album_id', 'album_id');
    }

    public function artists(){
        return $this->belongsToMany(Artist::class, 'album_artists', 'album_id', 'artist_id');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'album_genres', 'album_id', 'genre_id');
    }

    public static function getSpotifyData($album_id)
    {
        $spotifyWebAPI = SpotifySessionController::getClientAuthorization();

        return $spotifyWebAPI->getAlbum($album_id);
    }

    public static function getSpotifyMultipleData(array $albums_id) {

        $spotifyWebAPI = SpotifySessionController::getClientAuthorization();

        return $spotifyWebAPI->getAlbums($albums_id);
    }
}

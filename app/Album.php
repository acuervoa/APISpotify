<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Illuminate\Database\Eloquent\Model;
use SpotifyWebAPI\SpotifyWebAPI;

class Album extends Model
{

    protected $fillable = [
        'album_id',
        'name',
        'image_url',
        'image_thumb_url',
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


    public static function getAlbumsCompleteData($albums_id) {

        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        return $spotifyWebAPI->getAlbums($albums_id);
    }
}

<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = [
        'artist_id',
        'name',
        'image_url_640x640',
        'image_url_320x320',
        'image_url_160x160',
        'link_to'
    ];

    protected $primaryKey = 'artist_id';
    public $incrementing = false;

    public function albums() {
        return $this->belongsToMany(Album::class, 'album_artists', 'artist_id');
    }

    public function tracks() {
        return $this->belongsToMany(Track::class, 'artist_tracks', 'artist_id', 'track_id');
    }

    public static function getSpotifyData($artist_id)
    {
        $spotifyWebAPI = SpotifySessionController::getClientAuthorization();
        return $spotifyWebAPI->getArtist($artist_id);
    }
}

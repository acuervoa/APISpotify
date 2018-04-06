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

    protected $primaryKey = 'artist_id';
    public $incrementing = false;

    public function albums() {
        return $this->belongsToMany(Album::class, 'album_artists', 'artist_id');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'artist_genres', 'artist_id', 'genre_id');
    }

    public function tracks() {
        return $this->belongsToMany(Track::class, 'artist_tracks', 'artist_id', 'track_id');
    }

    public static function getArtistCompleteData($artist_id)
    {
        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        return $spotifyWebAPI->getArtist($artist_id);
    }
}

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
        'popularity',
        'played_at',
        'tracked_by',
        'album_id',
        'track_id'
    ];


    public static function getArtistsCompleteData($artists_id){
        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $artistsInfo = $spotifyWebAPI->getArtists($artists_id);

        return $artistsInfo;
    }
}

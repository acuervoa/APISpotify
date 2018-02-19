<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Illuminate\Database\Eloquent\Model;
use SpotifyWebAPI\SpotifyWebAPI;

class Album extends Model
{

    public static function getAlbumsCompleteData($albums_id) {

        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        return $spotifyWebAPI->getAlbums($albums_id);
    }
}

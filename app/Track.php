<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Illuminate\Database\Eloquent\Model;
use SpotifyWebAPI\SpotifyWebAPI;

class Track extends Model
{
    protected $fillable=[
        'played_at',
        'track_id',
        'name',
        'popularity',
    ];

    public static function getTracksInfo($track_ids) {

        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $tracksInfo = $spotifyWebAPI->getTracks($track_ids);

        return view('tracks.ranking', compact('tracksInfo'));

    }
}

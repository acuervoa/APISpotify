<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SpotifyWebAPI\SpotifyWebAPI;

class Track extends Model
{
    protected $fillable=[
        'played_at',
        'track_id',
        'name',
        'popularity',
        'by',
    ];

    public static function getTracksInfo($track_ids) {

        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $tracksInfo = $spotifyWebAPI->getTracks($track_ids);

        foreach($tracksInfo->tracks as &$a_track) {
            $reproductions = DB::table('tracks')
                               ->select('track_id', DB::raw('count(*) as total'))
                               ->where('track_id', $a_track->id)
                               ->groupBy('track_id')
                               ->first();
            $a_track->reproductions = $reproductions->total;
        }
        return view('tracks.ranking', compact('tracksInfo'));

    }
}

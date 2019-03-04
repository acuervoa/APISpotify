<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SpotifyWebAPI\SpotifyWebAPI;

class Track extends Model
{
    protected $fillable=[
        'track_id',
        'name',
        'album_id',
        'preview_url',
        'link_to',
        'duration_ms'
    ];

    protected $primaryKey='track_id';

    public $incrementing=false;

    public function profiles(){
        return $this->belongsToMany(SpotifyProfile::class, 'profile_tracks', 'track_id','profile_id')
           ->withPivot('played_at');
    }


    public static function getTracksCompleteData($track_ids){
        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        if (sizeof($track_ids) > 0) {
            $tracksInfo = $spotifyWebAPI->getTracks($track_ids);

            foreach ($tracksInfo->tracks as &$a_track) {
                $reproductions = self::getReproductions($a_track);
                $a_track->reproductions = $reproductions->total;

                $profiles = self::getProfileReproductions($reproductions);
                $a_track->profiles = $profiles;

                $ponderatedReproductions = 0;
                foreach ($profiles as $a_profile) {
                    $ponderatedReproductions += $a_profile->ponderatedReproductions;
                }

                $a_track->ponderatedReproductions = (int)$ponderatedReproductions;
            }

            usort($tracksInfo->tracks, function ($a, $b) {
                if ($a->ponderatedReproductions === $b->ponderatedReproductions) {
                    return ($a->reproductions <= $b->reproductions) ? -1 : 1;
                }
                return ($a->ponderatedReproductions > $b->ponderatedReproductions) ? -1 : 1;
            });
        return $tracksInfo;
        }

        return [];


    }

    public function album(){
        return $this->belongsTo(Album::class, 'album_id','album_id')->withDefault();
    }

    public static function getSpotifyData($track_id) {
        $spotifyWebAPI = SpotifySessionController::getClientAuthorization();

        return $spotifyWebAPI->getTrack($track_id);
    }


}

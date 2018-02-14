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
        'played_at',
        'track_id',
        'name',
        'popularity',
        'tracked_by',
    ];

    public static function getTracksInfo($track_ids) {

        $tracksInfo = self::getTracksCompleteData($track_ids);
        return view('tracks.ranking', compact('tracksInfo'));

    }

    public static function getTracksCompleteData($track_ids){
        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $tracksInfo = $spotifyWebAPI->getTracks($track_ids);

        foreach($tracksInfo->tracks as &$a_track) {
            $reproductions = self::getReproductions($a_track);
            $a_track->reproductions = $reproductions->total;

            $profiles = self::getProfileReproductions($reproductions);
            $a_track->profiles = $profiles;
        }

        return $tracksInfo;
    }

    /**
     * @param $a_track
     * @return mixed
     */
    public static function getReproductions($a_track)
    {
        $reproductions = DB::table('tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('track_id', $a_track->id)
            ->groupBy('track_id')
            ->first();

        return $reproductions;
    }

    /**
     * @param $reproductions
     * @return mixed
     */
    public static function getProfileReproductions($reproductions)
    {
        $profiles = DB::table('tracks')
            ->select('tracked_by', DB::raw('count(*) as times'))
            ->where('track_id', $reproductions->track_id)
            ->groupBy('tracked_by')
            ->get();


        foreach($profiles as $a_profile){
           $a_profile->played_at = self::getWhenPlayedAtTracked($reproductions->track_id, $a_profile->tracked_by);
        }



        return $profiles;
    }

    public static function getWhenPlayedAtTracked($track_id, $tracked_by){

        $played_at = DB::table('tracks')
            ->select('played_at')
            ->where('track_id', $track_id)
            ->where('tracked_by', $tracked_by)
            ->orderby('played_at', 'desc')
            ->get();

        return $played_at;
    }

    public function getPlayedAt(){
        return Carbon::createFromFormat('m/d/Y', $this->played_at);
    }
}

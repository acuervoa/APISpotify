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

    public function profiles(){
        return $this->belongsToMany(SpotifyProfile::class, 'profile_tracks', 'profile_id','id');//, 'track_id');
    }

    public function album(){
        return $this->belongsTo(Album::class, 'album_id','album_id')->withDefault();
    }



    public static function getTracksInfo($track_ids) {

       return self::getTracksCompleteData($track_ids);

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

            $ponderatedReproductions = 0;
            foreach ($profiles as $a_profile){
                $ponderatedReproductions += $a_profile->ponderatedReproductions;
            }

            $a_track->ponderatedReproductions = (int)$ponderatedReproductions;
        }

        usort($tracksInfo->tracks, function($a, $b){
            if($a->ponderatedReproductions === $b->ponderatedReproductions) {
                return ($a->reproductions <= $b->reproductions) ? -1 : 1;
            }
            return ($a->ponderatedReproductions > $b->ponderatedReproductions) ? -1 : 1;
        });

        return $tracksInfo;
    }

    /**
     * @param $a_track
     * @return mixed
     */
    public static function getReproductions($a_track)
    {
        $reproductions = DB::table('profile_tracks')
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
        $profiles = DB::table('profile_tracks')
            ->select('profile_id', DB::raw('count(*) as times'))
            ->where('track_id', $reproductions->track_id)
            ->groupBy('profile_id')
            ->get();

        foreach($profiles as $a_profile){
           $a_profile->played_at = self::getWhenPlayedAtTracked($reproductions->track_id, $a_profile->profile_id);
           $a_profile->realReproductions = $a_profile->times;
           $a_profile->ponderatedReproductions = round(sqrt($a_profile->times ) );
        }

        return $profiles;
    }

    public static function getWhenPlayedAtTracked($track_id, $tracked_by){

        $played_at = DB::table('profile_tracks')
            ->select('played_at')
            ->where('track_id', $track_id)
            ->where('profile_id', $tracked_by)
            ->orderby('played_at', 'desc')
            ->get();

        return $played_at;
    }

    public function getPlayedAt(){
        return Carbon::createFromFormat('m/d/Y', $this->played_at);
    }
}

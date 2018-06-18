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

    public function artists() {
        return $this->belongsToMany(Artist::class, 'artist_tracks', 'track_id', 'artist_id');
    }

    public function album(){
        return $this->belongsTo(Album::class, 'album_id','album_id')->withDefault();
    }



    public static function getTracksInfo($track_ids) {
       return self::getTracksCompleteData($track_ids);
    }

    public static function getTracksCompleteData(array $track_ids)
    {
        $clientToken = SpotifySessionController::clientCredentials();
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $tracks = [];
        foreach($track_ids as $track_id){
            $track = self::with(['album'])->find($track_id);

            if(empty($track->link_to)) {
                $trackInfo = $spotifyWebAPI->getTrack($track_id);
                $track->preview_url = $trackInfo->preview_url;
                $track->link_to = $trackInfo->href;
                $track->duration_ms = $trackInfo->duration_ms;

                $album = $track->album;

                $album->name = $trackInfo->album->name;
                $album->image_url_640x640 = isset($trackInfo->album->images[0]) ? $trackInfo->album->images[0]->url : '';
                $album->image_url_300x300 = isset($trackInfo->album->images[1]) ? $trackInfo->album->images[0]->url : '';
                $album->image_url_64x64 = isset($trackInfo->album->images[2]) ? $trackInfo->album->images[0]->url : '';
                $album->link_to = $trackInfo->album->href;

                $album->save();
                $track->save();
            }
            $tracks[] = $track;

        }



        foreach($tracks as $a_track) {


            $reproductions = self::getReproductions($a_track);
            $a_track->reproductions = $reproductions->total;

            usort($tracks, function ($a, $b) {
                return ($a->reproductions <= $b->reproductions) ? 1 : -1;
            });
        }

        return $tracks;
    }

    /**
     * @param $a_track
     * @return mixed
     */
    public static function getReproductions($a_track)
    {
        $reproductions = DB::table('profile_tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('track_id', $a_track->track_id)
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

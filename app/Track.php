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

    public static function getSpotifyData($track_id) {
        $spotifyWebAPI = SpotifySessionController::getClientAuthorization();

        return $spotifyWebAPI->getTrack($track_id);
    }


}

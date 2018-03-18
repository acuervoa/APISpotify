<?php

namespace App\Http\Controllers\Artist;

use App\Artist;
use App\Http\Controllers\Spotify\SpotifySessionController;
use App\Ranking;
use App\SpotifyProfile;
use App\Track;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SpotifyWebAPI\SpotifyWebAPI;

class ArtistController extends Controller
{
    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getGroupedArtists($limit) {

        $result = DB::table('profile_tracks')
            ->select('_id')
            ->join('tracks', 'tracks.track_id', '=', 'profile_tracks.track_id')
            ->join('album_artists', 'album_artists.album_id', '=', 'tracks.album_id')
            ->join('artists', 'album_artists.artist_id', '=', 'artists.artist_id')
            ->get();



        $artists = [];
        foreach($result as $a_track_id){
            dd($a_track_id);
            dd(Track::find($a_track_id));//->album->artists()->toArray();
        }
        dd($artists);
        $albums = DB::table('profile_tracks')
                    ->select('tracks')->load('albums')
                    ->toSql();

             dd($albums);

        return $artists;
    }


    public function rankingArtists()
    {
        return self::getArtistInfo(self::getArtistRanking(Ranking::MEDIUM));

    }

    public static function getArtistRanking($limit) {
        return self::getGroupedArtists($limit);
    }

    public static function getArtistInfo($album_ids) {
        return self::getArtistsCompleteData($album_ids);
    }

    public static function getReproductions($a_album)
    {
        return DB::table('profile_tracks')
                           ->select('artist_id', DB::raw('count(*) as total'))
                           ->where('artist_id', $a_album->id)
                           ->groupBy('artist_id')
                           ->first();

    }

    public static function getArtistsCompleteData($artists_ids){

        return Artist::select()->whereIn('artist_id',$artists_ids)->get();
    }
}

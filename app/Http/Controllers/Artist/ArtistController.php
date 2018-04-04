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


        $results = DB::table('artists')
            ->select('artists.artist_id', 'name', 'results.total')
            ->join(DB::raw(' 
                    (
                    select artist_tracks.artist_id, count(*) as total from artist_tracks where track_id in 
                        (
                            select track_id from tracks where track_id in
                            (
                                select track_id from profile_tracks
                            )
                        )
                    group by artist_id
                    order by total desc
                    )
                    as results'),
                    function ($join) {
                         $join->on('artists.artist_id', '=', 'results.artist_id');
                    }
            )->take($limit)->get();

        return $results; // ->pluck('artist_id')->all() ;

    }


    public function rankingArtists()
    {
        return self::getArtistInfo(self::getArtistRanking(Ranking::MEDIUM));

    }

    public static function getArtistRanking($limit) {

        $artists = self::getGroupedArtists($limit);

        return $artists->pluck('artist_id')->all();
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

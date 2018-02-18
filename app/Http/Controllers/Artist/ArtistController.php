<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Spotify\SpotifySessionController;
use App\Ranking;
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
        $albums = DB::table('artists')
                    ->select('artist_id', DB::raw('count(*) as total'))
                    ->groupBy('artist_id')
                    ->orderBy('total', 'desc')
                    ->take($limit)
                    ->get();

        return $albums;
    }


    public function rankingArtists()
    {
        return self::getArtistInfo(self::getArtistRanking(Ranking::MEDIUM));

    }

    public static function getArtistRanking($limit) {
        $albums = self::getGroupedArtists($limit);

        return $albums->pluck('artist_id')->all();

    }

    public static function getArtistInfo($album_ids) {
        return self::getArtistsCompleteData($album_ids);
    }

    public static function getReproductions($a_album)
    {
        $reproductions = DB::table('artists')
                           ->select('artist_id', DB::raw('count(*) as total'))
                           ->where('artist_id', $a_album->id)
                           ->groupBy('artist_id')
                           ->first();

        return $reproductions;
    }

    public static function getArtistsCompleteData($artists_ids){
        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $artistsInfo = $spotifyWebAPI->getArtists($artists_ids);

        foreach($artistsInfo->artists as &$a_artist){

            $reproductions = self::getReproductions($a_artist);
            $a_artist->reproductions = $reproductions->total;
        }

        return $artistsInfo;
    }
}

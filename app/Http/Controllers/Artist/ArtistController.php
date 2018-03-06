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
        $albums = DB::table('tracks')
                    ->select('album_id', DB::raw('count(*) as total'))
                    ->groupBy('album_id')
                    ->orderBy('total', 'desc')
                    ->take($limit)
                    ->get();

        foreach ($albums as $a_album){
            $artist = DB::table('album_artists')
                ->select('album_artists.artist_id', 'artists.name')
                ->join('artists', 'album_artists.artist_id', 'artists.artist_id')
                ->where('album_artists.album_id', $a_album->album_id)
                ->get();

                $artists[] = $artist;

        }
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
        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $artistsInfo = $spotifyWebAPI->getArtists(collect($artists_ids)->collapse()->pluck('artist_id')->all());

        foreach($artistsInfo->artists as &$a_artist){

            $reproductions = self::getReproductions($a_artist);
            $a_artist->reproductions = $reproductions->total;
        }

        return $artistsInfo;
    }
}

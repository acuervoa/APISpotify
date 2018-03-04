<?php

namespace App\Http\Controllers\Album;

use App\Http\Controllers\Spotify\SpotifySessionController;
use App\Ranking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SpotifyWebAPI\SpotifyWebAPI;

class AlbumController extends Controller
{

    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getGroupedAlbums($limit) {
        $albums = DB::table('albums')
                    ->select('album_id', DB::raw('count(*) as total'))
                    ->groupBy('album_id')
                    ->orderBy('total', 'desc')
                    ->take($limit)
                    ->get();

        return $albums;
    }


    public function rankingAlbums()
    {
        return self::getAlbumsInfo(self::getAlbumsRanking(Ranking::MEDIUM));

    }

    public static function getAlbumsRanking($limit) {
        $albums = self::getGroupedAlbums($limit);

        return $albums->pluck('album_id')->all();

    }

    public static function getAlbumsInfo($album_ids) {
         return self::getAlbumsCompleteData($album_ids);
    }

    public static function getReproductions($a_album)
    {

        $reproductions = DB::table('tracks')
                           ->select('album_id', DB::raw('count(*) as total'))
                           ->where('album_id', $a_album->id)
                           ->groupBy('album_id')
                           ->first();


        return $reproductions;
    }

    public static function getAlbumsCompleteData($album_ids){
        $clientToken = SpotifySessionController::clientCredentials();

        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $albumsInfo = $spotifyWebAPI->getAlbums($album_ids);
        foreach($albumsInfo->albums as &$a_album){

            $reproductions = self::getReproductions($a_album);
            $a_album->reproductions = $reproductions->total;
        }

        return $albumsInfo;
    }

}

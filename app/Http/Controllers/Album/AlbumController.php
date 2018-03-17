<?php

namespace App\Http\Controllers\Album;

use App\Album;
use Carbon\Carbon;

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

    /**
     * Get top albums from last 24 hours.
     *
     * @param  int $limit
     * @return array
     */
    public static function getAlbumsRankingLastDay($limit)
    {
        $albums = DB::table('tracks')
            ->select('album_id', DB::raw('count(*) as total'))
            ->where('played_at', '>=', Carbon::now()->subDay())
            ->groupBy('album_id')
            ->orderBy('total', 'desc')
            ->orderBy('album_id', 'desc')
            ->take($limit)
            ->get();

        return $albums->pluck('album_id')->all();
    }

    public static function getAlbumsInfo($album_ids) {
         return self::getAlbumsCompleteData($album_ids);
    }

    public static function getReproductions($a_album)
    {

        $reproductions = DB::table('tracks')
                           ->select('album_id', DB::raw('count(*) as total'))
                           ->where('album_id', $a_album->album_id)
                           ->groupBy('album_id')
                           ->first();


        return $reproductions;
    }

    public static function getAlbumsCompleteData($album_ids){

        return Album::select()->whereIn('album_id',$album_ids)->get();
    }

}

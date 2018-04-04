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
    private static function getGroupedAlbums($limit)
    {
        $results = DB::table('albums')
            ->select('albums.album_id', 'name', 'results.total')
            ->join(DB::raw(' 
                    (
                        select album_id, count(*) as total from tracks where track_id 
                        in (select track_id from profile_tracks order by played_at desc)
                        group by album_id
                        order by total desc) as results'),

                function ($join) {
                    $join->on('albums.album_id', '=', 'results.album_id');
                }
            )->orderBy('total', 'desc')
            ->take($limit)
            ->get();


        return $results;
    }


    public function rankingAlbums()
    {
        $albums = self::getAlbumsRanking(Ranking::SHORT);

        return self::getAlbumsInfo($albums);

    }

    public static function getAlbumsRanking($limit)
    {
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

    public static function getAlbumsInfo($album_ids)
    {

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

    public static function getAlbumsCompleteData($album_ids)
    {
        var_dump($album_ids);
        $albums = Album::select()->whereIn('album_id', $album_ids)->get();
        dd($albums);
    }

}

<?php

namespace App\Http\Controllers\Album;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlbumRankingController extends Controller
{


    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getTopReproductionsAlbums($limit)
    {

        $tracksByAlbum = DB::table('profile_tracks')
            ->join('tracks', 'profile_tracks.track_id', '=', 'tracks.track_id')
            ->select('profile_tracks.track_id', 'tracks.album_id');



        $results = DB::table(DB::raw("(" . $tracksByAlbum->toSql() .") as tracksByAlbum"))
            ->mergeBindings($tracksByAlbum)
            ->select('album_id', DB::raw('count(*) as total'))
            ->distinct()
            ->groupBy('album_id')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();


        return $results->pluck('album_id')->all();
    }


    public static function getAlbumsRanking($limit): array
    {
        return self::getTopReproductionsAlbums($limit);
    }

    /**
     * Get top albums from last 24 hours.
     *
     * @param  int $limit
     * @return array
     */
    public static function getAlbumsRankingLastDay($limit): array
    {

        $results =  $results = DB::table('albums')
            ->select('albums.*', 'results.total')
            ->join(
                DB::raw(' 
                    (
                        select album_id, count(*) as total from tracks where track_id 
                        in (select track_id from profile_tracks where played_at >=\''. Carbon::now()->subDay() . '\' )
                        group by album_id
                        order by total desc) as results'),
                function ($join) {
                    $join->on('albums.album_id', '=', 'results.album_id');
                }
            )->orderBy('total', 'desc')
            ->orderBy('album_id', 'desc')
            ->take($limit)
            ->get();

        return $results->pluck('album_id')->all();
    }

    public static function sortAlbumsByReproductions(array $albums)
    {
        foreach ($albums as $a_album) {
            $reproductions = AlbumController::getAlbumReproductions($a_album);
            $a_album->reproductions = $reproductions->total;

            usort($albums, function ($a, $b) {
                return ($a->reproductions <= $b->reproductions) ? 1 : -1;
            });
        }
        return $albums;
    }
}
